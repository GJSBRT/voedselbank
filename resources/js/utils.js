export function HasPermission(permission) {
    if (window.Permissions.includes('*')) {
        return true;
    }

    return window.Permissions.includes(permission);
}
