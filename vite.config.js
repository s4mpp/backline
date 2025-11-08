import { defineConfig } from 'vite'
import laravel from 'laravel-vite-plugin'

export default defineConfig({
  build: {
		rollupOptions: {
		  input: './assets/src/app.js',
		  output: {
		    entryFileNames: 'app.js',
		    dir: 'assets/dist/js',
		  },
		},
		minify: 'esbuild',
		sourcemap: false,
	},
})
