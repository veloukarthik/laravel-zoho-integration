import { useEffect } from "react";

const ZohoCallback = () => {
  useEffect(() => {
    const params = new URLSearchParams(window.location.search);
    const code = params.get("code");

    if (code) {
      console.log("Authorization Code:", code);

      // Exchange the code for an access token
      fetchToken(code);
    }
  }, []);

  const fetchToken = async (code) => {
    const data = {
      client_id: "1000.M404RRYT05LKIB6N0G02VYMIBY9BAI",
      client_secret: "6f586230a8e74525fcb11b45563ea964830ac02f40", // Not recommended to expose this
      grant_type: "authorization_code",
      redirect_uri: "http://localhost:8000/api/zoho-auth/callback",
      code: code,
    };

    try {
      const response = await fetch("https://accounts.zoho.com/oauth/v2/token", {
        method: "POST",
        headers: {
          "Content-Type": "application/x-www-form-urlencoded",
        },
        body: new URLSearchParams(data),
      });

      const result = await response.json();
      console.log("Token Response:", result);

      if (result.access_token) {
        // Store the tokens securely (not in localStorage for sensitive apps)
        localStorage.setItem("zoho_access_token", result.access_token);
        localStorage.setItem("zoho_refresh_token", result.refresh_token);

        alert("Zoho connected successfully!");
      } else {
        alert("Failed to fetch access token");
      }
    } catch (error) {
      console.error("Error fetching token:", error);
    }
  };

  return <div>Handling Zoho Callback...</div>;
};

export default ZohoCallback;
