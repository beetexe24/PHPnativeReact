import './index.css'
import 'flowbite';
import { BrowserRouter as Router } from 'react-router-dom';
import { initFlowbite } from 'flowbite';
import Mainrouter from './Router/Mainrouter';
import { useEffect } from 'react';
import { createRoot } from 'react-dom/client';

export default function Main(){
  useEffect(() => {
      initFlowbite();
  }, [])

  return(<Mainrouter></Mainrouter>)
}

const rootElement = document.querySelector("#root");
const root = createRoot(rootElement);

root.render(
  <Router>
      <Main />
  </Router>
);