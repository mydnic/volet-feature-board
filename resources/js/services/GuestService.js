export default {
    getGuestId() {
        let guestId = localStorage.getItem('vfb_guest_id');
        if (!guestId) {
            // Generate a UUID v4
            guestId = 'guest_' + ([1e7]+-1e3+-4e3+-8e3+-1e11).replace(/[018]/g, c =>
                (c ^ crypto.getRandomValues(new Uint8Array(1))[0] & 15 >> c / 4).toString(16)
            );
            localStorage.setItem('vfb_guest_id', guestId);
        }
        return guestId;
    }
}
