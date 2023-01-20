import React, { useEffect } from 'react';
import Loader from '../Layout/Loader';
import { applyActionCode, signOut } from 'firebase/auth';
import { auth } from '../../config';
import Link from 'next/link';
import styles, {layout} from '../../styles/style';
import {logo} from '../../assets'
import useState from 'react-usestateref'

const VerifyEmail = (props) => {
  const [state, setState] = useState({
    error: '',
    validCode: null,
    verifiedCode: false,
  });

  useEffect(() => {
    // Try to apply the email verification code.
    applyActionCode(auth, props.actionCode)
      .then(() => {
        // Email address has been verified.
        signOut(auth)
        localStorage.clear()
        setState({ ...state, validCode: true, verifiedCode: true });
      }, error => {
        // Code is invalid or expired. Ask the user to verify their email address
        // again.
        setState({ ...state, error: error.message, validCode: false, verifiedCode: true });
        signOut(auth)
        localStorage.clear()
      });
  }, []);

  let component;
  if (!state.verifiedCode) {
    component = <Loader/>;
  } else if (state.verifiedCode && state.validCode) {
    component = (
      <div className='bg-black flex flex-col flex-wrap items-center justify-center mt-40 py-20'>
        <img src={logo.src} alt="hoobank" className='w-[200px] h-[auto]' />
        <h1 className={`${styles.paragraph} w-[95%] m-auto text-center text-white mt-5`}>¡Tu email fue verificado correctamente!</h1>
        <p className={`${styles.paragraph} w-[95%] m-auto text-center text-white mt-5`}>Ya podes iniciar sesión con tus datos de usuario.</p>
        <Link href='/acceder'>
          <a className={`${layout.buttonOrange} text-center cursor-pointer mt-5`}>Iniciar sesión</a>
        </Link>
      </div>
    );
  } else if (state.verifiedCode && !state.validCode) {
    component = (
      <div className='bg-black flex flex-col flex-wrap items-center justify-center mt-40 py-20'>
        <img src={logo.src} alt="hoobank" className='w-[200px] h-[auto]' />
        <h1 className={`${styles.paragraph} w-[95%] m-auto text-center text-white mt-5`}>Hubo un error verificando tu email.</h1>
        <p className='text-red-500'>{state.error}</p>
        <Link href='/acceder'>
          <a className={`${layout.buttonOrange} text-center cursor-pointer mt-5`}>Volver a la página principal</a>
        </Link>
      </div>
    );
  }

  return component;
}

export default VerifyEmail;