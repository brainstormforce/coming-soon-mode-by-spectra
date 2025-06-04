/**
 * Header component for the Coming Soon Mode dashboard
 */
import { __ } from '@wordpress/i18n';

const Header = () => {
    return (
        <div className="csm-header">
            <div className="csm-logo">
                <img 
                    src={`${csm_data.plugin_url}/assets/images/logo.svg`} 
                    alt={__('Coming Soon Mode by Spectra', 'csm')} 
                />
            </div>
            <div className="csm-header-content">
                <h1>{__('Coming Soon Mode by Spectra', 'csm')}</h1>
                <p className="csm-description">
                    {__('Most lightweight Coming soon mode plugin ever by Spectra.', 'csm')}
                </p>
            </div>
        </div>
    );
};

export default Header;
