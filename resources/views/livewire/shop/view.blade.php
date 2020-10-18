<div>

    <h1 class="text-gray-600 text-center font-light tracking-wider text-4xl sm:mb-8 sm:text-6xl">
        {{ $shop->name }}
    </h1>

    <div class="text-center">
        <button
            class="{{ $isSubscribed ? 'bg-red-600 hover:bg-red-500' : 'bg-green-600 hover:bg-green-500' }} focus:outline-none text-white font-bold text-3xl p-4 rounded-lg shadow
{{ $error ? 'opacity-50 cursor-not-allowed' : '' }}"
            wire:click="$emit('{{ $isSubscribed ? 'unsubscribe' : 'subscribe' }}')"
            {{ $error ? 'disabled title="'.$error.'"' : '' }}
        >
            {{ $isSubscribed ? 'Unsubscribe' : 'Subscribe' }}
        </button>
    </div>

    @if ($isSubscribed)
        <div class="flex justify-center p-5">
            <div class="flex items-center bg-blue-400 text-white font-bold px-4 py-3" role="alert">
                <svg class="mr-2 w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                </svg>
                <p>You've subscribed for this shop updates</p>
            </div>
        </div>
    @endif

    @if ($isBlocked)
        <div class="flex justify-center p-5">
            <div class="flex items-center bg-orange-400 text-white font-bold px-4 py-3" role="alert">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                </svg>
                <p>You've blocked notifications for this site and won't be able to get updates</p>
            </div>
        </div>
    @endif
</div>

@push('scripts')
    <script>
        document.addEventListener('livewire:load', function () {
            registerServiceWorker()
        })

        Livewire.on('subscribe', () => {
            subscribe()
        })
        Livewire.on('unsubscribe', () => {
            unsubscribe()
        })

        function error(error, exception = null){
            @this.error = error
            console.log(error, exception)
        }

        function registerServiceWorker() {
            if (!('serviceWorker' in navigator)) {
                error('Service workers aren\'t supported in this browser')
                return
            }

            navigator
                .serviceWorker
                .register('/sw.js')
                .then(() => initialiseServiceWorker())
        }

        function initialiseServiceWorker() {
            if (!('showNotification' in ServiceWorkerRegistration.prototype)) {
                error('Notifications aren\'t supported')
                return
            }

            if (!('PushManager' in window)) {
                error('Push messaging isn\'t supported')
                return
            }

            if (Notification.permission === 'denied') {
                @this.isBlocked = true
                return
            }

            navigator
                .serviceWorker
                .ready
                .then(registration => {
                    registration
                        .pushManager
                        .getSubscription()
                        .then(subscription => {
                            @this.error = null

                            if (!subscription) {
                                return
                            }

                            updateSubscription(subscription)
                        })
                        .catch(e => {
                            error('Error while initializing. ', e)
                        })
                })
        }

        function updateSubscription(subscription) {
            const key = subscription.getKey('p256dh')
            const token = subscription.getKey('auth')
            const contentEncoding = (PushManager.supportedContentEncodings || ['aesgcm'])[0]

            const data = {
                endpoint : subscription.endpoint,
                publicKey : key ? btoa(String.fromCharCode.apply(null, new Uint8Array(key))) : null,
                authToken : token ? btoa(String.fromCharCode.apply(null, new Uint8Array(token))) : null,
                contentEncoding,
            }

            @this.updateSubscription(data)
        }


        function subscribe() {
            navigator
                .serviceWorker
                .ready
                .then(registration => {
                    const options = {userVisibleOnly : true}
                    const vapidPublicKey = window.Laravel.vapidPublicKey

                    if (vapidPublicKey) {
                        options.applicationServerKey = urlBase64ToUint8Array(vapidPublicKey)
                    }

                    registration
                        .pushManager
                        .subscribe(options)
                        .then(subscription => {
                            updateSubscription(subscription)
                        })
                        .catch(e => {
                            if (Notification.permission === 'denied') {
                                @this.isBlocked = true
                            } else {
                                error('Unable to subscribe. ', e)
                            }
                        })
                })
        }

        function urlBase64ToUint8Array (base64String) {
            const padding = '='.repeat((4 - base64String.length % 4) % 4)
            const base64 = (base64String + padding)
                .replace(/-/g, '+')
                .replace(/_/g, '/')

            const rawData = window.atob(base64)
            const outputArray = new Uint8Array(rawData.length)

            for (let i = 0; i < rawData.length; ++i) {
                outputArray[i] = rawData.charCodeAt(i)
            }

            return outputArray
        }


        function unsubscribe () {
            navigator
                .serviceWorker
                .ready
                .then(registration => {
                    registration
                        .pushManager
                        .getSubscription()
                        .then(subscription => {
                            if (!subscription) {
                                if (Notification.permission === 'denied') {
                                    @this.isBlocked = true
                                } else {
                                    error('Error while unsubscribing. No subscription.')
                                }
                                return
                            }

                            subscription
                                .unsubscribe()
                                .then(() => {
                                    @this.removeSubscription(subscription)
                                })
                                .catch(e => {
                                    error('Error while unsubscribing.', e)
                                })
                        })
                        .catch(e => {
                            error('Error while unsubscribing.', e)
                        })
                })
        }
    </script>
@endpush
