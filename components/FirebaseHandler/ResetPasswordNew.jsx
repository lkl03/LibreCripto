import React, { useEffect } from 'react';
import { auth, app } from '../../config';
import { verifyPasswordResetCode, confirmPasswordReset, signOut } from 'firebase/auth';
import { collection, getDocs, doc, query, where, getFirestore, updateDoc } from "firebase/firestore"
import styles, {layout} from '../../styles/style';
import Link from 'next/link';
import {logo} from '../../assets'
import useState from 'react-usestateref'

const ResetPasswordNew = (props) => {
  const [error, setError] = useState(null);
  const [email, setEmail] = useState('');
  const [password, setPassword] = useState('');
  const [showSuccess, setShowSuccess] = useState(false)
  const [datainEmail, setDatainEmail, datainEmailRef] = useState({
    email: '',
    name: '',
    password: ''
  })
  const [userName, setUserName, userNameRef] = useState('')  
  const [userID, setUserID, userIDRef] = useState('')  
  const db = getFirestore(app);

  const handleSubmit = async (e) => {
    e.preventDefault();
    try {
      const email = await verifyPasswordResetCode(auth, props.actionCode);
      setEmail(email);
      const q = query(collection(db, "users"), where("email", "==", email));
      const querySnapshot = await getDocs(q);
      querySnapshot.forEach((doc) => {
        // doc.data() is never undefined for query doc snapshots
        console.log(doc.id, " => ", doc.data().uid);
        setUserName(doc.data().name)
        setUserID(doc.data().uid)
        console.log(datainEmailRef.current)
        console.log(userIDRef.current)
        console.log(userNameRef.current)
      });
    } catch (error) {
      setError(error);
    }
  };

  const handleReset = async (e) => {
    e.preventDefault();
    try {
      await confirmPasswordReset(auth, props.actionCode, password);
      // Show success message
      setShowSuccess(true)
      setDatainEmail({
        email,
        name: userNameRef.current,
        password: password
      })
      fetch("../api/passwordchanged", {
        "method": "POST",
        "headers": { "content-type": "application/json" },
        "body": JSON.stringify(datainEmailRef.current)
      })
      updateDoc(doc(db, "users", userIDRef.current), {
        password
      })
      signOut(auth)
      localStorage.clear()
    } catch (error) {
      setError(error);
    }
  };

  if (error) {
    return <div className='bg-black flex flex-col flex-wrap items-center justify-center mt-40 py-20'>
    <p className='text-red-500'>{error.message}</p>
    <Link href='/acceder'>
          <a className={`${layout.buttonOrange} text-center cursor-pointer mt-5`}>Volver a la página principal</a>
    </Link>
    </div>;
  }

  return (
    <div className='bg-black flex flex-col flex-wrap items-center justify-center mt-40 py-20'>
    <img src={logo.src} alt="hoobank" className='w-[200px] h-[auto]' />
    {showSuccess ? 
    <div>
        <h1 className={`${styles.paragraph} w-full m-auto text-center text-white mt-5 mb-10`}>¡Contraseña actualizada correctamente!</h1>
        <Link href='/acceder'>
          <a className={`${layout.buttonOrange} text-center cursor-pointer`}>Volver a la página principal</a>
        </Link>
    </div>
    : ''}
      {!showSuccess && !email && <form onSubmit={handleSubmit}>
        <p className={`${styles.paragraph} w-full m-auto text-center text-white mt-5`}>Por favor cliqueá el siguiente botón para poder modificar tu contraseña.</p>
        <button type="submit" className={`${layout.buttonWhite} w-full text-center cursor-pointer mt-5`}>Verificar código</button>
      </form>}
      {!showSuccess && email && (
        <form onSubmit={handleReset}>
          <input
            className='input p-3 text-white outline-none w-full mt-5 text-center'
            type="password"
            placeholder="Ingresar nueva contraseña"
            value={password}
            onChange={(e) => setPassword(e.target.value)}
          />
          <button type="submit" className={`${layout.buttonWhite} w-full text-center cursor-pointer mt-5`}>Modificar contraseña</button>
        </form>
      )}
    </div>
  );
};

export default ResetPasswordNew;