import fs from 'node:fs';
import path from 'node:path';
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';
import { buildPrototypeDist } from './scripts/build-prototype-dist.mjs';

const MIME_TYPES = {
  '.html': 'text/html; charset=utf-8',
  '.css': 'text/css; charset=utf-8',
  '.js': 'application/javascript; charset=utf-8',
  '.json': 'application/json; charset=utf-8',
  '.jpg': 'image/jpeg',
  '.jpeg': 'image/jpeg',
  '.png': 'image/png',
  '.webp': 'image/webp',
  '.svg': 'image/svg+xml',
  '.ico': 'image/x-icon',
};

function eksporPrototypeVercel() {
  return {
    name: 'artspace-ekspor-prototype-vercel',
    apply: 'build',
    closeBundle() {
      buildPrototypeDist(process.cwd());
    },
  };
}

function pratinjauPrototypeDev() {
  return {
    name: 'artspace-pratinjau-prototype-dev',
    apply: 'serve',
    configureServer(server) {
      const rootDir = process.cwd();
      const distDir = path.join(rootDir, 'dist');
      const publicDir = path.join(rootDir, 'public');

      server.middlewares.use((req, res, next) => {
        if (!req.url || (req.method !== 'GET' && req.method !== 'HEAD')) {
          return next();
        }

        const pathname = decodeURIComponent(req.url.split('?')[0]);

        // Biarkan permintaan internal Vite & aset Laravel (@vite) ditangani langsung oleh Vite
        if (
          pathname.startsWith('/@') ||
          pathname.startsWith('/resources/') ||
          pathname.startsWith('/node_modules/') ||
          pathname.startsWith('/__vite')
        ) {
          return next();
        }

        const relPath = pathname.replace(/^\/+/, '');
        const candidates = [];

        if (relPath === '') {
          candidates.push(path.join(distDir, 'index.html'));
        } else {
          candidates.push(path.join(distDir, relPath));
          candidates.push(path.join(distDir, relPath.replace(/\/+$/, ''), 'index.html'));
          if (pathname.startsWith('/images/')) {
            candidates.push(path.join(publicDir, relPath));
          }
        }

        for (const candidate of candidates) {
          const normalized = path.resolve(candidate);
          const allowed =
            normalized.startsWith(path.resolve(distDir)) ||
            normalized.startsWith(path.resolve(publicDir));

          if (allowed && fs.existsSync(normalized) && fs.statSync(normalized).isFile()) {
            const ext = path.extname(normalized).toLowerCase();
            res.statusCode = 200;
            res.setHeader('Content-Type', MIME_TYPES[ext] || 'application/octet-stream');
            if (req.method === 'HEAD') {
              res.end();
              return;
            }
            fs.createReadStream(normalized).pipe(res);
            return;
          }
        }

        return next();
      });
    },
  };
}

export default defineConfig({
  plugins: [
    pratinjauPrototypeDev(),
    laravel({
      input: ['resources/css/app.css', 'resources/js/app.js'],
      refresh: true,
    }),
    tailwindcss(),
    eksporPrototypeVercel(),
  ],
  server: {
    host: '0.0.0.0',
    port: 3000,
    allowedHosts: true,
    watch: {
      ignored: ['**/storage/framework/views/**'],
    },
  },
});
