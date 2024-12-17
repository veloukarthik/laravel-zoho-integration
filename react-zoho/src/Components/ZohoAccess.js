import React, { useEffect, useState } from 'react';
import axios from 'axios';

const ZohoAccess = () => {
  const [contacts, setContacts] = useState([]);
  const [accounts, setAccounts] = useState([]);

  useEffect(() => {
    // Fetch contacts
    axios.get('http://localhost:8000/api/contacts')
      .then((response) => {
        setContacts(response.data.data); // Adjust based on Zoho response format
      })
      .catch((error) => {
        console.error('Error fetching contacts:', error);
      });

    // Fetch accounts
    axios.get('http://localhost:8000/api/accounts')
      .then((response) => {
        setAccounts(response.data.data); // Adjust based on Zoho response format
      })
      .catch((error) => {
        console.error('Error fetching accounts:', error);
      });
  }, []);

  return (
    <div>
      <h1>Zoho Contacts</h1>
      <ul>
        {contacts.map((contact) => (
          <li key={contact.id}>{contact.Full_Name}</li>
        ))}
      </ul>

      <h1>Zoho Accounts</h1>
      <ul>
        {accounts.map((account) => (
          <li key={account.id}>{account.Account_Name}</li>
        ))}
      </ul>
    </div>
  );
};

export default ZohoAccess;
