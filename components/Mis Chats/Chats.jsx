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


const ChatEngine = dynamic(() =>
  import("react-chat-engine").then((module) => module.ChatEngine)
);
const MessageFormSocial = dynamic(() =>
  import("react-chat-engine").then((module) => module.MessageFormSocial)
);

const Chats = () => {
    let { user, logout } = useContext(AppContext)
    console.log(user)
    const [loading, setLoading] = useState(false)
    const [showChat, setShowChat] = useState(false)
    const [username, setUsername] = useState('xx.03llkxx@gmail.com')
    const [usersecret, setUsersecret] = useState('GvkXoL2pSpTqg7jE8X3wTvxcSVp1')

    useEffect(() => {
        if (typeof document !== undefined) {
          setShowChat(true)
        }
    }, [])
    
    if (!showChat) return <div />
    return (
        <section id='chats' className={`flex md:flex-row flex-col md:items-center ${styles.paddingY} xs:mt-20`}>
            <div>
            <ChatEngine 
            height='calc(100ch - 200px)'
            projectID='280851f5-d7d7-41ef-8c21-3a3974c233bd'
            userName={username}
            userSecret={usersecret}
            renderNewMessageForm={() => <MessageFormSocial />}
            />
            </div>
        </section>
    )
}

export default Chats