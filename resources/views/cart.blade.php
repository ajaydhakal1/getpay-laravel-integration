<x-app-layout>
    <div class="py-5 flex flex-col justify-center items-center gap-4">
        @foreach ($products as $product)
            <div class="w-[600px] flex justify-between px-10 py-4 bg-white/30 rounded">
                <div>
                    <img src="{{ $product->image }}" alt="{{ $product->name }}" class="w-16 rounded-lg">
                </div>

                <div>
                    <h2 class="text-xl font-bold text-black dark:text-white">{{ $product->name }}</h2>
                    <p class="text-lg font-semibold text-green-300">${{ $product->price }}</p>
                </div>
            </div>
        @endforeach
        <div class="w-[600px] flex justify-between px-10 py-4 bg-white/30 rounded">
            <h1 class="text-2xl">Total:</h1>
            <h1 class="text-2xl font-bold text-green-300">${{ $cart->total }}</h1>
        </div>

        <div id="checkout" hidden></div>
        <button id="checkout-btn" class="py-2 px-5 border border-gray-200 rounded-3xl dark:text-white">Checkout</button>

        <script>
            function getJson() {
                // URL of the EventStream endpoint
                const url =
                    'https://uat-bank-getpay.nchl.com.np/ecom-web-checkout/v1/secure-merchant/transactions'; // Replace with the actual endpoint

                // Fetch the EventStream
                fetch(url, {
                        method: 'GET',
                        headers: {
                            'Accept': 'text/event-stream', // Request server to send SSE
                        }
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }

                        const reader = response.body.getReader();
                        const decoder = new TextDecoder();
                        let streamData = '';

                        // Read the data from the stream
                        reader.read().then(function processText({
                            done,
                            value
                        }) {
                            if (done) {
                                console.log("Stream finished.");
                                return;
                            }

                            // Decode and accumulate data from the stream
                            streamData += decoder.decode(value, {
                                stream: true
                            });

                            // Look for end-of-event data (you can adjust this depending on your stream format)
                            let endOfMessageIndex = streamData.indexOf('\n\n');
                            while (endOfMessageIndex !== -1) {
                                const event = streamData.substring(0, endOfMessageIndex);

                                try {
                                    // Parse the event as JSON data
                                    const eventData = JSON.parse(event);
                                    console.log('Received event:', eventData);

                                    // Process the parsed event data (access specific fields)
                                    if (eventData.status === "SUCCESS") {
                                        console.log("Token:", eventData.token);
                                        console.log("Authentication Info:", eventData.payerAuthInfo);
                                        // Add more handling logic based on your requirements
                                    }

                                } catch (error) {
                                    console.error('Error parsing event data:', error);
                                }

                                // Update the stream data for the next event
                                streamData = streamData.substring(endOfMessageIndex + 2);
                                endOfMessageIndex = streamData.indexOf('\n\n');
                            }

                            // Continue reading the stream
                            reader.read().then(processText);
                        });
                    })
                    .catch(error => {
                        console.error('Error fetching the EventStream:', error);
                    });

            }

            const options = {
                userInfo: {
                    name: "John Doe",
                    email: "john@gmail.com",
                    state: "Bagmati",
                    country: "Nepal",
                    zipcode: "44600",
                    city: "Kathmandu",
                    address: "Chabahil",
                },
                clientRequestId: "CLIENT123",

                // insert papInfo, oprKey, insKey provided to you
                papInfo: "eyJpbnN0aXR1dGlvbklkIjoiMTE5OSIsIm1pZCI6IjIwMDc1NDMyMTAwMDAwOCIsInRpZCI6IjIwMDc1NDM4In0",
                oprKey: "4fa4c6b9-3f91-43e5-9b4f-319f68187ba5",
                insKey: "000",
                websiteDomain: "http://localhost:5500",
                price: {{ $product->price }},
                businessName: "Dhani Pawan",
                imageUrl: "",
                currency: "NPR",

                // redirection callback url when payment is either success or fail
                callbackUrl: {
                    successUrl: '/success',
                    failUrl: '/fail',
                },
                // brand theme color to display in checkout page
                themeColor: "#5662FF",

                // accept html with inline css to display UI in checkout page
                orderInformationUI: `<div style="font-family:Arial;"><h3>Order Information</h3><div class="item" style=" 
            margin-bottom: 20px;">
            @foreach ($products as $product)
            <div class="item">
            <img style=" max-width: 50px;
            margin-right: 10px;" src={{$product->image}} 
            alt="image"
            class="rounded-xl">
            <p>{{ $product->name }}</p>
            <span>{{ $product->price }}</span>
        </div>
        @endforeach
        </div>`,

                onSuccess: (options) => {
                    //you can receive options if needed

                    // redirect to payment checkout page on success
                    window.location.href = "/payment"
                },

                onError: (error) => {
                    // if error occured during checkout
                    console.log(error);
                },

            };
            document.getElementById('checkout-btn').onclick = function(e) {
                options.baseUrl = "https://uat-bank-getpay.nchl.com.np/ecom-web-checkout/v1/secure-merchant/transactions";
                console.log('Base URL:', options.baseUrl);
                const getpay = new GetPay(options)
                getpay.initialize()
            }
        </script>
    </div>
</x-app-layout>
