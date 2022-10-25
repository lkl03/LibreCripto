import { Fragment, useState, useContext } from 'react'
import {close, menu, logo, logolc} from '../../assets'
import {navLinks} from '../../constants'
import { layout } from '../../styles/style'
import Link from 'next/link'
import Image from 'next/image'
import { AppContext } from '../AppContext'
import { MdDashboardCustomize, MdClose } from 'react-icons/md'
import { BiStats } from 'react-icons/bi'
import { GrTransaction } from 'react-icons/gr'
import { HiChatAlt2, HiLogout } from 'react-icons/hi'
import { FaHandsHelping } from 'react-icons/fa'

const Sidebar = () => {
  
  const [toggle, setToggle] = useState(false)

  let { user, logout } = useContext(AppContext)
  
  return (
    <nav className={`h-full flex flex-col py-6 justify-start items-center showSidebar`}>
      <Link href='/'>
        <a><img src={logolc.src} alt="hoobank" className='w-[60px] h-[auto]' /></a>
      </Link>
      <ul className='list-none flex flex-col justify-center items-center flex-1 gap-10 mt-20'>
        <li className='text-4xl text-white cursor-pointer tile-active'><MdDashboardCustomize /></li>
        <li className='text-4xl text-white cursor-pointer tile-hover'><BiStats /></li>
        <li className='text-4xl text-white cursor-pointer tile-hover'><HiChatAlt2 /></li>
        <li className='text-4xl text-white cursor-pointer tile-hover'><FaHandsHelping /></li>
      </ul>
      <button className='text-4xl text-white hover:text-red-500 transition-all duration-200 ease-in-out cursor-pointer mt-20' onClick={logout}>
            <HiLogout />
      </button>
    </nav>
  )
}

export default Sidebar