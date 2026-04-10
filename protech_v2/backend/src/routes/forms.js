import { Router } from 'express';
import { readForms, writeForms } from '../store.js';

const STATUS_VALUES = ['en_attente', 'en_cours', 'traitee'];
const STATUS_DEFAULT = 'en_attente';

function generateTicketId() {
  const now = new Date();
  const datePart = now.toISOString().slice(0, 10).replace(/-/g, '');
  const randomPart = Math.random().toString(36).slice(2, 7).toUpperCase();
  return `REQ-${datePart}-${randomPart}`;
}

function normalizeForm(entry) {
  const status = STATUS_VALUES.includes(entry.status) ? entry.status : STATUS_DEFAULT;
  return {
    ...entry,
    ticketId: entry.ticketId || generateTicketId(),
    status,
  };
}

export function createFormsRouter(io) {
  const formsRouter = Router();

  formsRouter.get('/', (req, res) => {
    try {
      const existing = readForms();
      const forms = existing.map(normalizeForm);
      const changed = forms.some((entry, index) => {
        return entry.ticketId !== existing[index].ticketId || entry.status !== existing[index].status;
      });
      if (changed) writeForms(forms);
      res.json(forms);
    } catch (e) {
      res.status(500).json({ error: e.message });
    }
  });

  formsRouter.post('/', (req, res) => {
    try {
      const { nom, societe, email, telephone, ville, sujet, message } = req.body;
      if (!nom || !email || !sujet) {
        return res.status(400).json({ error: 'Nom, email et sujet requis' });
      }
      const forms = readForms();
      const entry = {
        id: String(Date.now()),
        ticketId: generateTicketId(),
        nom,
        societe: societe || '',
        email,
        telephone: telephone || '',
        ville: ville || '',
        sujet,
        message: message || '',
        status: STATUS_DEFAULT,
        createdAt: new Date().toISOString(),
      };
      forms.push(entry);
      writeForms(forms);
      io.emit('form:created', entry);
      res.status(201).json(entry);
    } catch (e) {
      res.status(500).json({ error: e.message });
    }
  });

  formsRouter.patch('/:id/status', (req, res) => {
    try {
      const { id } = req.params;
      const { status } = req.body;
      if (!STATUS_VALUES.includes(status)) {
        return res.status(400).json({ error: 'Statut invalide' });
      }

      const forms = readForms().map(normalizeForm);
      const index = forms.findIndex((entry) => entry.id === id);
      if (index === -1) return res.status(404).json({ error: 'Demande introuvable' });

      forms[index] = { ...forms[index], status };
      writeForms(forms);
      io.emit('form:updated', forms[index]);
      res.json(forms[index]);
    } catch (e) {
      res.status(500).json({ error: e.message });
    }
  });

  return formsRouter;
}
