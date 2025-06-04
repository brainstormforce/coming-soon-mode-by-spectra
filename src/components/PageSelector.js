/**
 * Page Selector component for selecting pages in the Coming Soon Mode dashboard
 */
import { __ } from '@wordpress/i18n';
import { ComboboxControl } from '@wordpress/components';

const PageSelector = ({ 
    pages, 
    selectedPage, 
    selectedPages = [], 
    onChange, 
    label, 
    help, 
    isMulti = false 
}) => {
    // For single page selection
    if (!isMulti) {
        return (
            <div className="csm-page-selector">
                <ComboboxControl
                    label={label}
                    help={help}
                    value={selectedPage}
                    onChange={onChange}
                    options={pages}
                    allowReset={true}
                />
            </div>
        );
    }
    
    // For multiple page selection
    const handleMultiChange = (pageId) => {
        let newSelectedPages = [...selectedPages];
        
        if (newSelectedPages.includes(pageId)) {
            // Remove page if already selected
            newSelectedPages = newSelectedPages.filter(id => id !== pageId);
        } else {
            // Add page if not selected
            newSelectedPages.push(pageId);
        }
        
        onChange(newSelectedPages);
    };
    
    return (
        <div className="csm-page-selector csm-multi-selector">
            <label className="components-base-control__label">{label}</label>
            <div className="csm-multi-select-container">
                {pages.map(page => (
                    <div key={page.value} className="csm-multi-select-item">
                        <input
                            type="checkbox"
                            id={`page-${page.value}`}
                            checked={selectedPages.includes(page.value)}
                            onChange={() => handleMultiChange(page.value)}
                        />
                        <label htmlFor={`page-${page.value}`}>{page.label}</label>
                    </div>
                ))}
            </div>
            {help && <p className="components-base-control__help">{help}</p>}
        </div>
    );
};

export default PageSelector;
