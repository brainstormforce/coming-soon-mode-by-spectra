import { __ } from '@wordpress/i18n';

const TabNavigation = ({ activeTab, setActiveTab }) => {
    const tabs = [
        { id: 'general', label: __('General Settings', 'csm') },
        { id: 'access', label: __('Access Rules', 'csm') },
        { id: 'appearance', label: __('Appearance', 'csm') },
        { id: 'waiting', label: __('Waiting List', 'csm') },
    ];

    return (
        <div className="csm-tabs">
            {tabs.map((tab) => (
                <button
                    key={tab.id}
                    type="button"
                    className={`csm-tab ${activeTab === tab.id ? 'active' : ''}`}
                    onClick={() => setActiveTab(tab.id)}
                >
                    {tab.label}
                </button>
            ))}
        </div>
    );
};

export default TabNavigation;
