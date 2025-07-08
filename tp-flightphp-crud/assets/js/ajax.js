const apiBase = "http://localhost/EXAMEN-TRINOME-S4/tp-flightphp-crud/ws";

        function ajax(method, url, data, callback) {
            const xhr = new XMLHttpRequest();
            xhr.open(method, apiBase + url, true);
            xhr.setRequestHeader("Content-Type", "application/json");

            xhr.onreadystatechange = () => {
                if (xhr.readyState === 4) {
                    if (xhr.status >= 200 && xhr.status < 300) {
                        try {
                            callback(JSON.parse(xhr.responseText));
                        } catch (e) {
                            console.error("Erreur de parsing JSON:", e);
                            console.error("Réponse brute:", xhr.responseText);
                        }
                    } else {
                        console.error(`Erreur HTTP ${xhr.status}: ${xhr.statusText}`);
                        console.error("Réponse brute:", xhr.responseText);
                    }
                }
            };

            const sendData = data ? JSON.stringify(data) : null;
            xhr.send(sendData);
        }