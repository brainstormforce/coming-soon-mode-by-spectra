/**
 * User Role Selector component for selecting user roles in the Coming Soon Mode dashboard
 */
import { __ } from '@wordpress/i18n';
import MultiSelect from './MultiSelect';

const UserRoleSelector = ({ roles, selectedRoles, onChange }) => {
    const roleOptions = Object.entries(roles).map(([roleId, roleName]) => ({ value: roleId, label: roleName }));

    const handleChange = (values) => {
        onChange(values);
    };
    
    return (
        <div className="csm-role-selector">
            <label className="components-base-control__label">
                {__('Select User Roles', 'csm')}
            </label>
            <MultiSelect options={roleOptions} value={selectedRoles} onChange={handleChange} />
        </div>
    );
};

export default UserRoleSelector;
