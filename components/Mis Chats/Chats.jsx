import { useContext, useEffect, useRef } from 'react'
import Link from 'next/link'
import styles, { layout } from '../../styles/style'
import { AppContext } from '../AppContext'
import { HiSearch, HiOutlineRefresh } from 'react-icons/hi'
import { FaMapMarkerAlt, FaBitcoin, FaChevronDown } from 'react-icons/fa'

import { collection, onSnapshot, getDocs, getDoc, doc, orderBy, query, where, getFirestore } from "firebase/firestore"
import { app } from '../../config'
import { useGeolocated } from "react-geolocated";
import { convertDistance, getPreciseDistance } from 'geolib'
import axios from "axios";
import { Circles } from 'react-loader-spinner'
import Moment from 'react-moment';
import 'moment/locale/es';
//import Talk from 'talkjs';
import dynamic from 'next/dynamic'
import { useRouter } from 'next/router'
import useState from 'react-usestateref'


const ChatEngine = dynamic(() =>
  import("react-chat-engine").then((module) => module.ChatEngine)
);
const MessageFormSocial = dynamic(() =>
  import("react-chat-engine").then((module) => module.MessageFormSocial)
);

const Chats = () => {

    const router = useRouter();

    const db = getFirestore(app);

    let { user, logout } = useContext(AppContext)
    console.log(user)
    const [loading, setLoading] = useState(true)
    const [showChat, setShowChat] = useState(false)
    const [username, setUsername, usernameRef] = useState('')
    const [usersecret, setUsersecret, usersecretRef] = useState('')

    useEffect(() => {
        const userInfo = localStorage.getItem('user') !== 'undefined' ? JSON.parse(localStorage.getItem('user')) : localStorage.clear()
        const getUser = async () => {
          const itemsRef = query(collection(db, "users"), where('uid', '==', userInfo?.uid));
          const querySnapshot = await getDocs(itemsRef);
          let data = querySnapshot.docs.map(doc => ({ ...doc.data(), id: doc.id }));
          console.log(data[0]);
          setUsername(data[0]?.publicID)
          console.log(usernameRef.current)
        }
      getUser()
      setUsersecret(userInfo?.uid)
      setTimeout(() => {
        if (typeof document !== undefined) {
          setShowChat(true)
          setLoading(false)
        }
      }, 1000)
    }, [])

  useEffect(() => {
    setTimeout(() => {
      if (usernameRef.current != '' && usersecretRef.current != '') {
        axios.get('https://api.chatengine.io/users/', {
          params: {
            username: usernameRef.current,
            secret: usersecretRef.current
          },
          headers: {
            'Private-key': '07707db6-68e3-40c0-b17c-b71a74c742d8'
          }
        })
      }
    }, 2000)
  }, [router.isReady])

  if (!showChat) return <div />
    return (
        <section id='chats' className={`${styles.paddingY} xs:mt-20`}>
            {loading ? <div className='mx-auto mt-4'>
                <Circles height="70" width="70" color="#fe9416" ariaLabel="circles-loading" wrapperStyle={{}} wrapperClass="" visible={true} />
            </div> : ''}
            <div>
            <ChatEngine 
            height='calc(100ch - 200px)'
            projectID='280851f5-d7d7-41ef-8c21-3a3974c233bd'
            userName={usernameRef.current}
            userSecret={usersecretRef.current}
            renderNewMessageForm={() => <MessageFormSocial autocomplete="off" />}
            offset={-3}
            />
            </div>
        </section>
    )
}

export default Chats