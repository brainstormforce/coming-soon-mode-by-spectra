/**
 * User Role Selector component for selecting user roles in the Coming Soon Mode dashboard
 */
import { __ } from '@wordpress/i18n';
import { CheckboxControl } from '@wordpress/components';

const UserRoleSelector = ({ roles, selectedRoles, onChange }) => {
    const handleRoleChange = (role) => {
        let newSelectedRoles = [...selectedRoles];
        
        if (newSelectedRoles.includes(role)) {
            // Remove role if already selected
            newSelectedRoles = newSelectedRoles.filter(r => r !== role);
        } else {
            // Add role if not selected
            newSelectedRoles.push(role);
        }
        
        onChange(newSelectedRoles);
    };
    
    return (
        <div className="csm-role-selector">
            <label className="components-base-control__label">
                {__('Select User Roles', 'csm')}
            </label>
            <div className="csm-roles-container">
                {Object.entries(roles).map(([roleId, roleName]) => (
                    <CheckboxControl
                        key={roleId}
                        label={roleName}
                        checked={selectedRoles.includes(roleId)}
                        onChange={() => handleRoleChange(roleId)}
                    />
                ))}
            </div>
        </div>
    );
};

export default UserRoleSelector;
