<x-app-layout>
    <div class="h-screen flex flex-col items-center px-10 my-10 gap-10">
        <div class="text-center">
            <h1 class="text-3xl font-bold">Payment Successful ✔️</h1>
        </div>

        <div>
            <table class="border-2 border-black">
                <thead>
                    <tr>
                        <th class="px-4 py-2">Key</th>
                        <th class="px-4 py-2">Value</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="px-4 py-2">Token</td>
                        <td class="px-4 py-2" id="token"></td>
                    </tr>
                    <tr>
                        <td class="px-4 py-2">ID</td>
                        <td class="px-4 py-2" id="tokenId"></td>
                    </tr>
                    <tr>
                        <td class="px-4 py-2">Server Opr Secret</td>
                        <td class="px-4 py-2" id="serverOprSecret"></td>
                    </tr>
                    <tr>
                        <td class="px-4 py-2">Our Opr Secret</td>
                        <td class="px-4 py-2" id="ourOprSecret"></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        // Function to get the 'token' from the URL parameters
        function getTokenFromURL() {
            const urlParams = new URLSearchParams(window.location.search);
            return urlParams.get('token');
        }

        function decodeToken(token) {
            const decoded = atob(token);
            const json = JSON.parse(decoded);
            return json;
        }


        const inputString = "4fa4c6b9-3f91-43e5-9b4f-319f68187ba527dae434b8ed4bf3a05ae12d0d11a33c";
        const base64String = btoa(inputString);
        console.log("Base64 String:", base64String);

        function generateOprSecret() {
            const oprKey = "4fa4c6b9-3f91-43e5-9b4f-319f68187ba5";
            const id = decodeToken(getTokenFromURL()).id;
            const oprSecret = oprKey + id;
            return oprSecret;
        }

        async function sha256ToBase64(str) {
            const encoder = new TextEncoder();
            const data = encoder.encode(str);

            // Hash the data using SHA-256
            const hashBuffer = await crypto.subtle.digest('SHA-256', data);

            // Convert the ArrayBuffer to a Base64 string
            const hashArray = Array.from(new Uint8Array(hashBuffer));
            const base64String = btoa(String.fromCharCode(...hashArray));
            return base64String;
        }


        sha256ToBase64(generateOprSecret()).then(base64EncodedString => {
            document.getElementById('ourOprSecret').textContent = base64EncodedString;
        });

        const result = decodeToken(getTokenFromURL());
        const serverOprSecret = result.oprSecret;
        document.getElementById('serverOprSecret').textContent = serverOprSecret;
        const tokenId = result.id;
        document.getElementById('tokenId').textContent = tokenId;

        // Get the token from URL
        const token = getTokenFromURL();
        console.log(token);
        document.getElementById('token').textContent = token;
    </script>
</x-app-layout>
