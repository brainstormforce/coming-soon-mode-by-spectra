/**
 * User Role Selector component for selecting user roles in the Coming Soon Mode dashboard
 */
import { __ } from '@wordpress/i18n';
import { FormTokenField } from '@wordpress/components';

const UserRoleSelector = ({ roles, selectedRoles, onChange }) => {
    const roleOptions = Object.entries(roles).map(([roleId, roleName]) => ({ id: roleId, name: roleName }));
    const suggestions = roleOptions.map((r) => r.name);

    const selectedRoleNames = selectedRoles
        .map((id) => roles[id])
        .filter(Boolean);

    const handleTokenChange = (tokens) => {
        const ids = roleOptions
            .filter((r) => tokens.includes(r.name))
            .map((r) => r.id);
        onChange(ids);
    };
    
    return (
        <div className="csm-role-selector">
            <label className="components-base-control__label">
                {__('Select User Roles', 'csm')}
            </label>
            <FormTokenField
                value={selectedRoleNames}
                onChange={handleTokenChange}
                suggestions={suggestions}
                __experimentalShowHowManySelected={false}
            />
        </div>
    );
};

export default UserRoleSelector;
