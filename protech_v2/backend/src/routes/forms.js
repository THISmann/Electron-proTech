import { Router } from 'express';
import { readForms, writeForms } from '../store.js';

export const formsRouter = Router();

formsRouter.get('/', (req, res) => {
  try {
    const forms = readForms();
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
      nom,
      societe: societe || '',
      email,
      telephone: telephone || '',
      ville: ville || '',
      sujet,
      message: message || '',
      createdAt: new Date().toISOString(),
    };
    forms.push(entry);
    writeForms(forms);
    res.status(201).json(entry);
  } catch (e) {
    res.status(500).json({ error: e.message });
  }
});
