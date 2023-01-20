import { useContext, useState, useEffect, useRef } from 'react'
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


const ChatEngine = dynamic(() =>
  import("react-chat-engine").then((module) => module.ChatEngine)
);
const MessageFormSocial = dynamic(() =>
  import("react-chat-engine").then((module) => module.MessageFormSocial)
);

const Chats = () => {

    const router = useRouter();

    let { user, logout } = useContext(AppContext)
    console.log(user)
    const [loading, setLoading] = useState(false)
    const [showChat, setShowChat] = useState(false)
    const [username, setUsername] = useState('')
    const [usersecret, setUsersecret] = useState('')

    useEffect(() => {
        if (typeof document !== undefined) {
          setShowChat(true)
        }
        const userInfo = localStorage.getItem('user') !== 'undefined' ? JSON.parse(localStorage.getItem('user')) : localStorage.clear()
        setUsername(userInfo?.displayName)
        setUsersecret(userInfo?.uid)
        axios.get(
            'https://api.chatengine.io/users/',
            {headers: {"Private-key": '07707db6-68e3-40c0-b17c-b71a74c742d8'}}
        ).then(function (response) {
          console.log(response);
        });
    }, [])

    useEffect(() => {
      const getUserInfo = localStorage.getItem('user') !== 'undefined' ? JSON.parse(localStorage.getItem('user')) : localStorage.clear()
      axios.put(
        'https://api.chatengine.io/users/',
        {"username": getUserInfo?.displayName, "secret": getUserInfo?.uid},
        {headers: {"Private-key": '07707db6-68e3-40c0-b17c-b71a74c742d8'}}
      ).then(function (response) {
        console.log(response);
      });
    }, [router.isReady])
    
    if (!showChat) return <div />
    return (
        <section id='chats' className={`${styles.paddingY} xs:mt-20`}>
            <div>
            <ChatEngine 
            height='calc(100ch - 200px)'
            projectID='280851f5-d7d7-41ef-8c21-3a3974c233bd'
            userName={username}
            userSecret={usersecret}
            renderNewMessageForm={() => <MessageFormSocial />}
            offset={-3}
            />
            </div>
        </section>
    )
}

export default Chats