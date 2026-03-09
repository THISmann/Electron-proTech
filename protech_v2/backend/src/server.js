import express from 'express';
import cors from 'cors';
import { formsRouter } from './routes/forms.js';
import { blogRouter } from './routes/blog.js';

const app = express();
const PORT = process.env.PORT || 4000;
app.use(cors());
app.use(express.json());

app.use('/api/forms', formsRouter);
app.use('/api/blog', blogRouter);

app.get('/api/health', (req, res) => {
  res.json({ ok: true });
});

app.listen(PORT, () => {
  console.log(`API ProTech v2 listening on http://localhost:${PORT}`);
});
