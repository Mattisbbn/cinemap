<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            Subscription
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-2xl px-4 sm:px-6 lg:px-8">
            <div class="overflow-hidden rounded-3xl border border-gray-200 bg-white shadow-sm">
                <div class="border-b border-gray-100 px-6 py-5">
                    <h1 class="text-2xl font-semibold text-gray-900">Subscription</h1>
                    <p class="mt-1 text-sm text-gray-500">Paiement Stripe en mode test.</p>
                </div>

                @if (auth()->user()->subscribed('default'))
                    <div class="p-6">
                        <div class="rounded-2xl bg-green-50 px-4 py-3 text-green-700">
                            Vous êtes abonné !
                        </div>
                    </div>
                @else
                    <div class="p-6">
                        <div class="mb-6 rounded-2xl bg-gray-50 px-4 py-3">
                            <div class="text-sm text-gray-500">Offre</div>
                            <div class="mt-1 text-2xl font-semibold text-gray-900">20€ / mois</div>
                        </div>

                        <form class="space-y-5" id="subscription-form" method="POST"
                            action="{{ route('subscription.subscribe') }}">
                            @csrf
                            <div>
                                <x-input-label for="card-holder-name" value="Nom sur la carte" />
                                <x-text-input id="card-holder-name" type="text" class="mt-1 block w-full" required />
                            </div>

                            <div class="mt-4">
                                <label class="block text-sm font-medium text-gray-700">Informations de paiement</label>
                                <div id="card-element"
                                    class="mt-1 block w-full rounded-md border border-gray-300 p-3 shadow-sm"></div>
                                <div id="card-errors" class="mt-2 text-sm text-red-600" role="alert"></div>
                            </div>

                            <input type="hidden" name="payment_method_id" id="payment_method_id">

                            <x-primary-button id="card-button" data-secret="{{ $intent->client_secret }}"
                                class="w-full justify-center">
                                S’abonner
                            </x-primary-button>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </div>



    <script src="https://js.stripe.com/v3/"></script>
    <script>
        const subscriptionForm = document.querySelector('#subscription-form');

        const stripe = Stripe(`{{ env('STRIPE_KEY') }}  `);
        const elements = stripe.elements();
        const cardElement = elements.create('card');
        cardElement.mount('#card-element');

        const cardButton = document.getElementById('card-button');
        const clientSecret = cardButton.dataset.secret;
        const cardHolderName = document.getElementById('card-holder-name');

        subscriptionForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            cardButton.disabled = true;

            const {
                setupIntent,
                error
            } = await stripe.confirmCardSetup(
                clientSecret, {
                    payment_method: {
                        card: cardElement,
                        billing_details: {
                            name: cardHolderName.value
                        }
                    }
                }
            );

            if (error) {
                document.getElementById('card-errors').textContent = error.message;
                cardButton.disabled = false;
            } else {
                // Succès : on met l'ID du PaymentMethod dans le champ caché et on soumet
                document.getElementById('payment_method_id').value = setupIntent.payment_method;
                document.getElementById('subscription-form').submit();
            }
        });
    </script>
</x-app-layout>
