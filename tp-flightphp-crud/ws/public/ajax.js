const apiBase = "http://localhost:8007";

function ajax(method, url, data, successCallback, errorCallback) {
    const xhr = new XMLHttpRequest();
    xhr.open(method, apiBase + url, true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = () => {
        if (xhr.readyState === 4) {
            if (xhr.status === 200 || xhr.status === 201) {
                try {
                    const response = xhr.responseText ? JSON.parse(xhr.responseText) : [];
                    successCallback(response);
                } catch (e) {
                    console.error(`Erreur de parsing JSON: ${e.message}, Response: ${xhr.responseText}`);
                    if (errorCallback) {
                        errorCallback(`Erreur de parsing JSON: ${e.message}`);
                    } else {
                        alert(`Erreur de parsing JSON: ${e.message}`);
                    }
                }
            } else {
                console.error(`Erreur ${xhr.status}: ${xhr.responseText}`);
                if (errorCallback) {
                    errorCallback(`Erreur ${xhr.status}: ${xhr.responseText}`);
                } else {
                    alert(`Erreur: ${xhr.status} - ${xhr.responseText}`);
                }
            }
        }
    };
    xhr.onerror = () => {
        const errorMsg = 'Erreur réseau lors de la requête AJAX';
        console.error(errorMsg);
        if (errorCallback) {
            errorCallback(errorMsg);
        } else {
            alert(errorMsg);
        }
    };
    xhr.send(data);
}