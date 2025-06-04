/**
 * Coming Soon Mode by Spectra - React Admin Dashboard
 * Main entry point for the React application
 */
import { render } from '@wordpress/element';
import App from './App';

// Wait for DOM to be ready
document.addEventListener('DOMContentLoaded', () => {
    const container = document.getElementById('csm-react-root');
    if (container) {
        render(<App />, container);
    }
});
