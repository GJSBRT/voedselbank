export function hasPermission(permission) {    
    try {
        if (window.Permissions.includes('*')) {
            return true;
        }
        
        return window.Permissions.includes(permission);
    } catch (error) {
        location.reload();
    }
}
