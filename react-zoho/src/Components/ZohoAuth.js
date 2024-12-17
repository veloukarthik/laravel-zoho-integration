import React from 'react';

const ZohoLogin = () => {
  const clientID = `1000.M404RRYT05LKIB6N0G02VYMIBY9BAI`;
  const zohoAuthUrl = `https://accounts.zoho.com/oauth/v2/auth?client_id=${clientID}&response_type=code&redirect_uri=http://localhost:3000/zoho-callback&scope=ZohoCRM.modules.contacts.READ,ZohoCRM.modules.accounts.READ&access_type=offline`;

  const handleLogin = () => {
    // Redirect the user to Zoho's authorization URL
    window.location.href = zohoAuthUrl;
  };

  return (
    <div>
      <button onClick={handleLogin}>Login with Zoho</button>
    </div>
  );
};

export default ZohoLogin;
