import express from 'express';
import cors from 'cors';
import { createServer } from 'http';
import { Server } from 'socket.io';
import { createFormsRouter } from './routes/forms.js';
import { blogRouter } from './routes/blog.js';

const app = express();
const PORT = process.env.PORT || 4000;
const httpServer = createServer(app);
const io = new Server(httpServer, {
  cors: {
    origin: ['http://localhost:5173', 'http://localhost:5174'],
    methods: ['GET', 'POST'],
  },
});

app.use(cors());
app.use(express.json());

app.use('/api/forms', createFormsRouter(io));
app.use('/api/blog', blogRouter);

app.get('/api/health', (req, res) => {
  res.json({ ok: true });
});

httpServer.listen(PORT, () => {
  console.log(`API ProTech v2 listening on http://localhost:${PORT}`);
});
