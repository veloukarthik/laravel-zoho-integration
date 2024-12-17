import React, { useEffect } from 'react';

const ZohoCallback = () => {
  useEffect(() => {
    const urlParams = new URLSearchParams(window.location.search);
    const code = urlParams.get('code'); // Get the authorization code from URL

    if (code) {
      // Pass the code to your Laravel backend to exchange for the access token
      fetch(`http://localhost:8000/api/zoho-auth/callback?code=${code}`)
        .then((response) => response.json())
        .then((data) => {
          console.log('Response from backend:', data);
          // Handle the response (e.g., display contacts and accounts)
        })
        .catch((error) => {
          console.error('Error:', error);
        });
    }
  }, []);

  return (
    <div>
      <h2>Redirecting...</h2>
    </div>
  );
};

export default ZohoCallback;
