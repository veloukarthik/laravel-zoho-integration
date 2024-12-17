import axios from 'axios';
import { useState, useEffect } from 'react';
import {createBrowserRouter,RouterProvider} from 'react-router-dom'
import ZohoAuth from './Components/ZohoAuth';
import ZohoAccess from './Components/ZohoAccess';
import ZohoCallback from './Components/ZohoCallback';
const App = () => {

  const router = createBrowserRouter([
    {
      path: '/',
      element: <ZohoAuth />
    },
    {
      path: '/zoho-callback',
      element: <ZohoCallback />
    },
    {
      path: '/zoho-access',
      element: <ZohoAccess />
    }
  ])

  return (
    <div>
        <RouterProvider router={router}></RouterProvider>
    </div>
  );
};

export default App;
