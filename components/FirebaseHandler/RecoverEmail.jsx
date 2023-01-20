import React, { useEffect, useContext } from 'react';
import Loader from '../Layout/Loader';
import { checkActionCode, applyActionCode, sendPasswordResetEmail, signOut } from 'firebase/auth';
import { collection, getDocs, doc, query, where, getFirestore, updateDoc } from "firebase/firestore"
import { auth, app } from '../../config';
import useState from 'react-usestateref'
import styles, {layout} from '../../styles/style';
import {logo} from '../../assets'
import { AppContext } from '../AppContext';
import Link from 'next/link';

const RecoverEmail = (props) => {
  const [state, setState] = useState({
    error: '',
    restoredEmail: '',
    resetSent: false,
    validCode: null,
    verifiedCode: false,
  });

  let { logout } = useContext(AppContext)

  const db = getFirestore(app);

  const [user, setUser, userRef] = useState('')
  const [userID, setUserID, userIDRef] = useState('')  

  useEffect(() => {
    // Confirm the action code is valid.
      checkActionCode(auth, props.actionCode)
      .then(info => {
        // Get the restored email address.
        const restoredEmail = info['data']['email'];
        const previousEmail = info['data']['previousEmail'];
        // Revert to the old email.
        const getData = async () => {
          const q = query(collection(db, "users"), where("email", "==", previousEmail));
          const querySnapshot = await getDocs(q);
          querySnapshot.forEach((doc) => {
            // doc.data() is never undefined for query doc snapshots
            console.log(doc.id, " => ", doc.data());
            setUserID(doc.data().uid)
            console.log(userIDRef.current)
            localStorage.setItem('userID', JSON.stringify(userIDRef.current))
          });
        }
        getData()
        applyActionCode(auth, props.actionCode)
          .then(() => {
            // Account email reverted to restoredEmail
            setState({ restoredEmail, validCode: true, verifiedCode: true });
            setTimeout(() => {
            console.log('this is:' + userIDRef.current)
            updateDoc(doc(db, "users", userIDRef.current), {
              email: restoredEmail
            })
            signOut(auth)
            localStorage.clear()
            }, 3000)
          })
      }, error => {
        // Invalid code.
        setState({ error: error.message, validCode: false, verifiedCode: true });
      });
  }, []);

  const sendReset = () => {
    // You might also want to give the user the option to reset their password
    // in case the account was compromised:
    sendPasswordResetEmail(auth, state.restoredEmail)
    .then(() => {
        // Password reset confirmation sent. Ask user to check their email.
        setState({ ...state, resetSent: true });
        signOut(auth)
        localStorage.clear()
    });
  }

  let component;
  if (!state.verifiedCode) {
    component = <Loader/>;
  } else if (state.resetSent) {
    component = (
      <div className='bg-black flex flex-col flex-wrap items-center justify-center mt-40 py-20'>
        <img src={logo.src} alt="hoobank" className='w-[200px] h-[auto]' />
        <h1 className={`${styles.paragraph} w-[95%] m-auto text-center text-white mt-5`}>Por favor revisa tu correo electrónico.</h1>
        <p className={`${styles.paragraph} w-[95%] m-auto text-center text-white mt-5`}>Enviamos un link a {state.restoredEmail} para que puedas reestablecer tu contraseña.</p>
        <Link href='/acceder'>
          <a className={`${layout.buttonOrange} text-center cursor-pointer mt-5`}>Volver a la página principal</a>
        </Link>
      </div>
    );
  } else if (state.verifiedCode && state.validCode) {
    component = (
      <div className='bg-black flex flex-col flex-wrap items-center justify-center mt-40 py-20'>
        <img src={logo.src} alt="hoobank" className='w-[200px] h-[auto]' />
        <h1 className={`${styles.paragraph} w-[95%] m-auto text-center text-white mt-5`}>Email actualizado correctamente.</h1>
        <p className={`${styles.paragraph} w-[95%] m-auto text-center text-white mt-5`}>Tu email fue actualizado nuevamente a {state.restoredEmail}. <br></br> Si vos no solicitaste cambiar tu email de acceso, es probable que tu cuenta esté en peligro. <br></br> Podes solicitar un cambio de contraseña cliqueando el siguiente botón.</p>
        <button className={`${layout.buttonOrange} text-center cursor-pointer mt-5`} onClick={sendReset}>Modificar contraseña</button>
        <Link href='/acceder'>
          <a className={`${layout.buttonWhite2} text-center cursor-pointer mt-5`}>Volver a la página principal</a>
        </Link>
      </div>
    );
  } else if (state.verifiedCode && !state.validCode) {
    component = (
      <div className='bg-black flex flex-col flex-wrap items-center justify-center mt-40 py-20'>
        <img src={logo.src} alt="hoobank" className='w-[200px] h-[auto]' />
        <h1 className={`${styles.paragraph} w-[95%] m-auto text-center text-white mt-5`}>Hubo un error modificando tu email.</h1>
        <p className='text-red-500'>{state.error}</p>
        <Link href='/acceder'>
          <a className={`${layout.buttonOrange} text-center cursor-pointer mt-5`}>Volver a la página principal</a>
        </Link>
      </div>
    );
  }

  return component;
}

export default RecoverEmail;