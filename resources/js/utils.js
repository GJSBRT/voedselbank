export function hasPermission(permission) {
    if (window.Permissions === undefined) {
        location.reload();
    }
    
    if (window.Permissions.includes('*')) {
        return true;
    }

    return window.Permissions.includes(permission);
}
