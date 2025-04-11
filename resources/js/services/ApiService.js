import GuestService from './GuestService';

export default {
    async request(url, options = {}) {
        const headers = {
            'Content-Type': 'application/json',
            'X-Guest-ID': GuestService.getGuestId(),
            ...options.headers
        };

        const response = await fetch(url, {
            ...options,
            headers
        });

        if (!response.ok) {
            throw new Error('Network response was not ok');
        }

        return response.json();
    },

    async post(url, data = {}) {
        return this.request(url, {
            method: 'POST',
            body: JSON.stringify(data)
        });
    }
}
