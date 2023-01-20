import React, { useState, useEffect } from 'react';
import Loader from '../Layout/Loader';
import { auth } from '../../config';
import { verifyPasswordResetCode, confirmPasswordReset } from 'firebase/auth';
import { useRouter } from 'next/router'

const ResetPassword = (props) => {
  const router = useRouter();
  const [state, setState] = useState({
    email: null,
    error: '',
    password: '',
    success: false,
    validCode: true,
    verifiedCode: false,
  });

  useEffect(() => {
    // Verify the password reset code is valid.
    verifyPasswordResetCode(auth, props.actionCode)
    .then(email => {
        setState({ ...state, email, validCode: true, verifiedCode: true });
      }, error => {
        // Invalid or expired action code. Ask user to try to reset the password
        // again.
        setState({ ...state, error: error.message, validCode: false, verifiedCode: true });
      });
  }, [router.isReady]);

  const handleResetPassword = (event) => {
    event.preventDefault();
    const newPassword = state.password;

    // Save the new password.
    confirmPasswordReset(auth, props.actionCode, newPassword)
      .then(() => {
        // Password reset has been confirmed and new password updated.
        setState({ ...state, success: true });
      }, error => {
        // Error occurred during confirmation. The code might have expired or the
        // password is too weak.
        setState({ ...state, error: error.message });
      });
  }

  const setText = (evt) => {
    setState({ ...state, password: evt.target.value });
  }

  let component;
  if (!state.verifiedCode) {
    component = <Loader/>;
  } else if (state.success) {
    component = (
      <div className="ResetPassword">
        <h1>Password changed</h1>
        <p>You can now sign in with your new password</p>
      </div>
    );
  } else if (state.verifiedCode && state.validCode) {
    component = (
      <div className="ResetPassword">
        <h1>Reset your password</h1>
        <div>for <span>{state.email}</span></div>

        <form onSubmit={handleResetPassword}>

          {state.error ? <div className="error">{state.error}</div> : ''}

          <input
            onChange={setText}
            value={state.password}
            type="password"
            placeholder="New password"
            required
          />
          <input
            type="submit"
            value="SAVE"
          />
        </form>
      </div>
    );
  } else if (state.verifiedCode && !state.validCode) {
    component = (
      <div className="ResetPassword">
        <h1>Try resetting your password again</h1>
        <p className="error">{state.error}</p>
      </div>
    );
  }
}

export default ResetPassword;
