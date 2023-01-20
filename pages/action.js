import { useEffect } from 'react';
import { useRouter } from 'next/router'
import RecoverEmail from '../components/FirebaseHandler/RecoverEmail';
import ResetPassword from '../components/FirebaseHandler/ResetPassword';
import ResetPasswordNew from '../components/FirebaseHandler/ResetPasswordNew';
import VerifyEmail from '../components/FirebaseHandler/VerifyEmail';
import useState from 'react-usestateref'

// http://localhost:3000/action?mode=resetPassword&oobCode=ABC123&apiKey=AIzaSy

// mode - The user management action to be completed
// oobCode - A one-time code, used to identify and verify a request
// apiKey - Your Firebase project's API key, provided for convenience

const Action = (props) => {

  const router = useRouter();

  const [mode, setMode, modeRef] = useState('')
  const [actionCode, setActionCode, actionCodeRef] = useState('')


  useEffect(() => {
    console.log(router.query)
    console.log('before:' + mode)
    setMode(router.query.mode)
    setActionCode(router.query.oobCode)
    console.log('after:' + modeRef.current)
  }, [router.isReady]);

  switch (modeRef.current) {
    case 'resetPassword':
      // Display reset password handler and UI.
      return <ResetPasswordNew actionCode={actionCodeRef.current} />;
      break
    case 'recoverEmail':
      // Display email recovery handler and UI.
      return <RecoverEmail actionCode={actionCodeRef.current} />;
      break
    case 'verifyEmail':
      // Display email verification handler and UI.
      return <VerifyEmail actionCode={actionCodeRef.current} />;
      break
    default:
      // Error: invalid mode.
      return (
        <div className="Action">
          <h1>Error encountered</h1>
          <p>The selected page mode is invalid.</p>
        </div>
      );
  }

}

export default Action;