/**
 * Coming Soon Mode by Spectra - Main App Component
 */
import { useState, useEffect } from '@wordpress/element';
import { __ } from '@wordpress/i18n';
import { 
    Card, 
    CardHeader, 
    CardBody, 
    CardFooter,
    Button,
    Panel,
    PanelBody,
    PanelRow,
    ToggleControl,
    RadioControl,
    CheckboxControl,
    SelectControl,
    Spinner,
    Notice
} from '@wordpress/components';
import { Icon, check } from '@wordpress/icons';
import apiFetch from '@wordpress/api-fetch';
import './styles/app.css';

// Components
import Header from './components/Header';
import Footer from './components/Footer';
import PageSelector from './components/PageSelector';
import UserRoleSelector from './components/UserRoleSelector';
import TabNavigation from './components/TabNavigation';

const App = () => {
    // Initial state with default values to avoid loading screen
    const [settings, setSettings] = useState({
        csm_mode: 'live',
        csm_show_page: '',
        csm_page: [],
        csm_template: 'page',
        csm_who_can_access: 'logged',
        csm_roles: [],
        csm_appearance: 'loadonly_content',
        dis_header: false,
        dis_footer: false,
        dis_sidebar: false
    });

    // UI state
    const [loading, setLoading] = useState(false); // Changed to false for instant UI display
    const [saving, setSaving] = useState(false);
    const [saveSuccess, setSaveSuccess] = useState(false);
    const [error, setError] = useState(null);
    const [pages, setPages] = useState([]);
    const [userRoles, setUserRoles] = useState([]);
    const [signups, setSignups] = useState([]);
    const [activeTab, setActiveTab] = useState('general');

    // Fetch settings and data on component mount
    useEffect(() => {
        const fetchData = async () => {
            try {
                // Fetch all data in parallel for faster loading
                const [settingsResponse, pagesResponse, rolesResponse, signupsResponse] = await Promise.all([
                    apiFetch({ path: '/csm/v1/settings' }),
                    apiFetch({ path: '/wp/v2/pages?per_page=100' }),
                    apiFetch({ path: '/csm/v1/roles' }),
                    apiFetch({ path: '/csm/v1/signups' })
                ]);
                
                // Process the responses
                setSettings(settingsResponse);
                
                const formattedPages = pagesResponse.map(page => ({
                    value: page.id.toString(),
                    label: page.title.rendered
                }));
                setPages(formattedPages);
                
                setUserRoles(rolesResponse);
                setSignups(signupsResponse);
                
                // Hide loading state
                setLoading(false);
            } catch (err) {
                setError(__('Failed to load settings. Please refresh the page.', 'csm'));
                setLoading(false);
            }
        };
        
        // Start fetching immediately
        fetchData();
    }, []);

    // Handle form submission
    const handleSubmit = async (e) => {
        e.preventDefault();
        setSaving(true);
        setError(null);
        setSaveSuccess(false);
        
        try {
            await apiFetch({
                path: '/csm/v1/settings',
                method: 'POST',
                data: settings
            });
            
            setSaveSuccess(true);
            setTimeout(() => setSaveSuccess(false), 3000);
        } catch (err) {
            setError(__('Failed to save settings. Please try again.', 'csm'));
        } finally {
            setSaving(false);
        }
    };

    // Handle input changes
    const handleChange = (name, value) => {
        setSettings(prev => ({
            ...prev,
            [name]: value
        }));
    };

    if (loading) {
        return (
            <div className="csm-loading">
                <Spinner />
                <p>{__('Loading settings...', 'csm')}</p>
            </div>
        );
    }

    return (
        <div className="csm-dashboard">
            <Header />
            <TabNavigation activeTab={activeTab} setActiveTab={setActiveTab} />
            
            {error && (
                <Notice status="error" isDismissible={false}>
                    {error}
                </Notice>
            )}
            
            {saveSuccess && (
                <Notice status="success" isDismissible={false}>
                    <div className="csm-success-message">
                        <Icon icon={check} />
                        {__('Settings saved successfully!', 'csm')}
                    </div>
                </Notice>
            )}
            
            <form onSubmit={handleSubmit}>
                {activeTab === 'general' && (
                    <Card className="csm-card">
                        <CardHeader>
                            <h2>{__('General Settings', 'csm')}</h2>
                        </CardHeader>
                        <CardBody>
                            <Panel>
                                <PanelBody title={__('Mode Selection', 'csm')} initialOpen={true}>
                                    <PanelRow>
                                        <RadioControl
                                            label={__('Select Mode', 'csm')}
                                            help={__('Choose between Live mode and Coming Soon mode', 'csm')}
                                            selected={settings.csm_mode}
                                            options={[
                                                { label: __('Live', 'csm'), value: 'live' },
                                                { label: __('Coming Soon', 'csm'), value: 'comming-soon' }
                                            ]}
                                            onChange={(value) => handleChange('csm_mode', value)}
                                        />
                                    </PanelRow>
                                    {settings.csm_mode === 'live' && (
                                        <p className="csm-help-text">
                                            {__('If Live is selected then a website is visible for all.', 'csm')}
                                        </p>
                                    )}
                                    {settings.csm_mode === 'comming-soon' && (
                                        <p className="csm-help-text">
                                            {__('If Coming Soon is selected then the site visitors will redirect to the dedicated page.', 'csm')}
                                        </p>
                                    )}
                                </PanelBody>

                                {settings.csm_mode !== 'live' && (
                                    <>
                                        <PanelBody title={__('Template', 'csm')} initialOpen={true}>
                                            <PanelRow>
                                                <SelectControl
                                                    label={__('Choose Template', 'csm')}
                                                    value={settings.csm_template}
                                                    options={[
                                                        { label: __('Custom Page', 'csm'), value: 'page' },
                                                        { label: __('Minimal', 'csm'), value: 'minimal' },
                                                        { label: __('Gradient', 'csm'), value: 'gradient' },
                                                        { label: __('Signup', 'csm'), value: 'signup' }
                                                    ]}
                                                    onChange={(value) => handleChange('csm_template', value)}
                                                />
                                            </PanelRow>
                                        </PanelBody>

                                        {settings.csm_template === 'page' && (
                                            <PanelBody title={__('Page Selection', 'csm')} initialOpen={true}>
                                                <PanelRow>
                                                    <PageSelector
                                                        pages={pages}
                                                        selectedPage={settings.csm_show_page}
                                                        onChange={(value) => handleChange('csm_show_page', value)}
                                                        label={__('Select Page', 'csm')}
                                                        help={__('The site visitors will be redirected to the selected page if Coming Soon mode is active.', 'csm')}
                                                    />
                                                </PanelRow>
                                                <PanelRow>
                                                    <PageSelector
                                                        pages={pages}
                                                        selectedPages={settings.csm_page}
                                                        onChange={(value) => handleChange('csm_page', value)}
                                                        label={__('Exclude Pages', 'csm')}
                                                        help={__('The site visitors will be able to access selected page even Coming Soon mode is active.', 'csm')}
                                                        isMulti={true}
                                                    />
                                                </PanelRow>
                                            </PanelBody>
                                        )}
                                    </>
                                )}
                            </Panel>
                        </CardBody>
                    </Card>
                )}

                {activeTab === 'access' && (
                    <Card className="csm-card">
                        <CardHeader>
                            <h2>{__('Access Rules', 'csm')}</h2>
                        </CardHeader>
                        <CardBody>
                            <Panel>
                                <PanelBody title={__('Live Site Access', 'csm')} initialOpen={true}>
                                    <PanelRow>
                                        <RadioControl
                                            label={__('Who can access the live site?', 'csm')}
                                            selected={settings.csm_who_can_access}
                                            options={[
                                                { label: __('All logged-in users', 'csm'), value: 'logged' },
                                                { label: __('Custom', 'csm'), value: 'custom' }
                                            ]}
                                            onChange={(value) => handleChange('csm_who_can_access', value)}
                                        />
                                    </PanelRow>
                                    {settings.csm_who_can_access === 'custom' && (
                                        <PanelRow>
                                            <UserRoleSelector
                                                roles={userRoles}
                                                selectedRoles={settings.csm_roles}
                                                onChange={(value) => handleChange('csm_roles', value)}
                                            />
                                        </PanelRow>
                                    )}
                                    <p className="csm-help-text">
                                        {__('Select the users who can access the live site even Coming Soon mode is activated.', 'csm')}
                                    </p>
                                </PanelBody>
                            </Panel>
                        </CardBody>
                    </Card>
                )}

                {activeTab === 'appearance' && (
                    <Card className="csm-card">
                        <CardHeader>
                            <h2>{__('Appearance Options', 'csm')}</h2>
                        </CardHeader>
                        <CardBody>
                            <Panel>
                                <PanelBody title={__('Page Appearance', 'csm')} initialOpen={true}>
                                    <PanelRow>
                                        <RadioControl
                                            label={__('Appearance Options', 'csm')}
                                            selected={settings.csm_appearance}
                                            options={[
                                                { label: __('Display Page Content Only', 'csm'), value: 'loadonly_content' },
                                                { label: __('More Custom Options', 'csm'), value: 'dis_more_option' }
                                            ]}
                                            onChange={(value) => handleChange('csm_appearance', value)}
                                        />
                                    </PanelRow>
                                    {settings.csm_appearance === 'dis_more_option' && (
                                        <div className="csm-custom-options">
                                            <CheckboxControl
                                                label={__('Disable Header', 'csm')}
                                                checked={settings.dis_header}
                                                onChange={(value) => handleChange('dis_header', value)}
                                            />
                                            <CheckboxControl
                                                label={__('Disable Footer', 'csm')}
                                                checked={settings.dis_footer}
                                                onChange={(value) => handleChange('dis_footer', value)}
                                            />
                                            <CheckboxControl
                                                label={__('Disable Sidebar', 'csm')}
                                                checked={settings.dis_sidebar}
                                                onChange={(value) => handleChange('dis_sidebar', value)}
                                            />
                                        </div>
                                    )}
                                    <p className="csm-help-text">
                                        {__('Make the selected page more interactive by controlling the website components.', 'csm')}
                                    </p>
                                </PanelBody>
                            </Panel>
                        </CardBody>
                    </Card>
                )}

                {activeTab === 'waiting' && (
                    <Card className="csm-card">
                        <CardHeader>
                            <h2>{__('Waiting List', 'csm')}</h2>
                        </CardHeader>
                        <CardBody>
                            {signups.length === 0 && (
                                <p>{__('No signups yet.', 'csm')}</p>
                            )}
                            {signups.length > 0 && (
                                <table className="csm-signups-table">
                                    <thead>
                                        <tr>
                                            <th>{__('Name', 'csm')}</th>
                                            <th>{__('Email', 'csm')}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {signups.map((s) => (
                                            <tr key={s.id}>
                                                <td>{s.name}</td>
                                                <td>{s.email}</td>
                                            </tr>
                                        ))}
                                    </tbody>
                                </table>
                            )}
                        </CardBody>
                    </Card>
                )}

                <div className="csm-sticky-save">
                    <Button
                        isPrimary
                        type="submit"
                        isBusy={saving}
                        disabled={saving}
                    >
                        {saving ? __('Saving...', 'csm') : __('Save Settings', 'csm')}
                    </Button>
                    <Button
                        variant="secondary"
                        onClick={() => window.open(`${csm_data.site_url}?csm_preview=1`, '_blank')}
                        style={{ marginLeft: '8px' }}
                    >
                        {__('Preview', 'csm')}
                    </Button>
                </div>
            </form>

            <Footer />
        </div>
    );
};

export default App;
