(() => {
    'use strict'

    const WebPush = {
        init() {
            self.addEventListener('push', this.notificationPush.bind(this))
            self.addEventListener('notificationclick', this.notificationClick.bind(this))
            self.addEventListener('notificationclose', this.notificationClose.bind(this))
        },

        /**
         * Handle notification push event.
         *
         * https://developer.mozilla.org/en-US/docs/Web/Events/push
         *
         * @param {NotificationEvent} event
         */
        notificationPush(event) {
            if (!(self.Notification && self.Notification.permission === 'granted')) {
                return
            }

            // https://developer.mozilla.org/en-US/docs/Web/API/PushMessageData
            if (event.data) {
                event.waitUntil(
                    this.sendNotification(event.data.json()),
                )
            }
        },

        /**
         * Send notification to the user.
         *
         * https://developer.mozilla.org/en-US/docs/Web/API/ServiceWorkerRegistration/showNotification
         *
         * @param {PushMessageData|Object} data
         */
        sendNotification(data) {
            return self.registration.showNotification(data.title, data)
        },

        /**
         * Handle notification click event.
         *
         * https://developer.mozilla.org/en-US/docs/Web/Events/notificationclick
         *
         * @param {NotificationEvent} event
         */
        notificationClick(event) {
            if (event.action === 'open_shop') {
                console.log(event)
                self.clients.openWindow('/shops/' + event.data.id)
            } else {
                self.clients.openWindow('/')
            }
        },

        /**
         * Handle notification close event (Chrome 50+, Firefox 55+).
         *
         * https://developer.mozilla.org/en-US/docs/Web/API/ServiceWorkerGlobalScope/onnotificationclose
         *
         * @param {NotificationEvent} event
         */
        notificationClose(event) {
            self.registration.pushManager.getSubscription().then(subscription => {
                // Do something...
            })
        },
    }

    WebPush.init()
})()
