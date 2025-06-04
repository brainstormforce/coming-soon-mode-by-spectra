/**
 * Footer component for the Coming Soon Mode dashboard
 */
import { __ } from '@wordpress/i18n';

const Footer = () => {
    return (
        <div className="csm-footer">
            <p>
                {__('Coming Soon Mode by Spectra', 'csm')} &copy; {new Date().getFullYear()} 
                <a href="https://brainstormforce.com" target="_blank" rel="noopener noreferrer">
                    {__('Brainstorm Force', 'csm')}
                </a>
            </p>
            <div className="csm-footer-links">
                <a href="https://wordpress.org/support/plugin/coming-soon-mode-by-spectra/" target="_blank" rel="noopener noreferrer">
                    {__('Support', 'csm')}
                </a>
                <a href="https://wordpress.org/plugins/coming-soon-mode-by-spectra/" target="_blank" rel="noopener noreferrer">
                    {__('Rate Plugin', 'csm')}
                </a>
            </div>
        </div>
    );
};

export default Footer;
