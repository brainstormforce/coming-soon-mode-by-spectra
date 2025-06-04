const { useState, useEffect } = wp.element;
const { Button, SelectControl, RadioControl, CheckboxControl, PanelBody, PanelRow } = wp.components;

function App() {
    const pages = csmSettings.pages.map( p => ( { label: p.post_title, value: parseInt(p.ID) } ) );
    const roles = Object.entries( csmSettings.roles ).map( ( [ slug, data ] ) => ( { label: data.name, value: slug } ) );

    const [mode, setMode] = useState( csmSettings.csm_mode );
    const [showPage, setShowPage] = useState( parseInt(csmSettings.csm_show_page) || 0 );
    const [excludePages, setExcludePages] = useState( csmSettings.csm_page || [] );
    const [whoCanAccess, setWhoCanAccess] = useState( csmSettings.csm_who_can_access );
    const [roleValues, setRoleValues] = useState( csmSettings.csm_roles || [] );
    const [appearance, setAppearance] = useState( csmSettings.csm_appearance || 'loadonly_content' );
    const [disableHeader, setDisableHeader] = useState( !!csmSettings.dis_header );
    const [disableFooter, setDisableFooter] = useState( !!csmSettings.dis_footer );
    const [disableSidebar, setDisableSidebar] = useState( !!csmSettings.dis_sidebar );

    const saveSettings = () => {
        wp.apiFetch( {
            path: '/csm/v1/settings',
            method: 'POST',
            data: {
                nonce: csmSettings.nonce,
                csm_mode: mode,
                csm_show_page: showPage,
                csm_page: excludePages,
                csm_who_can_access: whoCanAccess,
                csm_roles: roleValues,
                csm_appearance: appearance,
                dis_header: disableHeader ? 'on' : '',
                dis_footer: disableFooter ? 'on' : '',
                dis_sidebar: disableSidebar ? 'on' : ''
            }
        } ).then( () => {
            alert( 'Settings saved' );
        } ).catch( () => {
            alert( 'Error saving settings' );
        } );
    };

    return wp.element.createElement('div', { className: 'csm-react-admin' },
        wp.element.createElement('h2', null, 'Coming Soon Mode By Spectra'),
        wp.element.createElement('div', { className: 'csm-control-group' },
            wp.element.createElement( RadioControl, {
                label: 'Select Mode',
                selected: mode,
                options: [
                    { label: 'Live', value: 'live' },
                    { label: 'Coming Soon', value: 'comming-soon' }
                ],
                onChange: setMode
            } ),
            mode !== 'live' && wp.element.createElement( SelectControl, {
                label: 'Select Page',
                value: showPage,
                options: [ { label: 'Select page', value: 0 }, ...pages ],
                onChange: ( val ) => setShowPage( parseInt( val ) )
            } ),
            mode !== 'live' && wp.element.createElement( SelectControl, {
                multiple: true,
                label: 'Exclude pages',
                value: excludePages,
                options: pages,
                onChange: ( val ) => setExcludePages( Array.isArray( val ) ? val : [ val ] )
            } ),
            mode !== 'live' && wp.element.createElement( RadioControl, {
                label: 'Live Site Access',
                selected: whoCanAccess,
                options: [
                    { label: 'All logged-in users', value: 'logged' },
                    { label: 'Custom', value: 'custom' }
                ],
                onChange: setWhoCanAccess
            } ),
            mode !== 'live' && whoCanAccess === 'custom' && wp.element.createElement( 'div', {},
                roles.map( role => (
                    wp.element.createElement( CheckboxControl, {
                        key: role.value,
                        label: role.label,
                        checked: roleValues.includes( role.value ),
                        onChange: ( checked ) => {
                            if ( checked ) {
                                setRoleValues( [ ...roleValues, role.value ] );
                            } else {
                                setRoleValues( roleValues.filter( r => r !== role.value ) );
                            }
                        }
                    } )
                ) )
            ),
            mode !== 'live' && wp.element.createElement( RadioControl, {
                label: 'Page Appearance',
                selected: appearance,
                options: [
                    { label: 'Display Page Content Only', value: 'loadonly_content' },
                    { label: 'More Custom Options', value: 'dis_more_option' }
                ],
                onChange: setAppearance
            } ),
            appearance === 'dis_more_option' && wp.element.createElement( 'div', {},
                wp.element.createElement( CheckboxControl, {
                    label: 'Disable Header',
                    checked: disableHeader,
                    onChange: setDisableHeader
                } ),
                wp.element.createElement( CheckboxControl, {
                    label: 'Disable Footer',
                    checked: disableFooter,
                    onChange: setDisableFooter
                } ),
                wp.element.createElement( CheckboxControl, {
                    label: 'Disable Sidebar',
                    checked: disableSidebar,
                    onChange: setDisableSidebar
                } )
            )
        ),
        wp.element.createElement( Button, { isPrimary: true, onClick: saveSettings }, 'Save Settings' )
    );
}

wp.element.addFilter ? null : null; // placeholder to ensure script loaded after wp.element
wp.domReady( function() {
    wp.element.render( wp.element.createElement( App ), document.getElementById( 'csm-admin-app' ) );
} );
