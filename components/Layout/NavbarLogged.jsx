import { Fragment, useState, useContext, useEffect } from 'react'
import {close, menu, logo} from '../../assets'
import {navLinks} from '../../constants'
import styles, { layout } from '../../styles/style'
import Link from 'next/link'
import Image from 'next/image'
import { AppContext } from '../AppContext'
import { MdOutlineKeyboardArrowDown, MdClose } from 'react-icons/md'

const Navbar = ({title}) => {
  
  const [toggle, setToggle] = useState(false)

  let { user, logout } = useContext(AppContext)

  return (
    <nav className={`w-full flex xs:flex-row flex-col py-6 justify-between items-center bg-transparent`}>
      <h2 className={`${styles.heading3} xs:flex hidden`}>{title}</h2>
      <div className='flex gap-4 justify-center items-center'>
        <div className="rounded-full h-11 w-11 profile-icon">
          <img className='rounded-full' src={user && user.photoURL !== null ? user.photoURL : 'https://i.pinimg.com/originals/65/25/a0/6525a08f1df98a2e3a545fe2ace4be47.jpg'} alt="" />
        </div>
        <div className='flex flex-col'>
          <p className='text-white font-medium text-md'>{user ? user.displayName : ''}</p>
          <p className='text-[#ffffff80] italic'>{user ? `@${user?.displayName.split(/\s+/).join('').toLowerCase()}` : ''}</p>
        </div>
        <div className='flex justify-end items-center'>
          <div className='w-[28px] h-[28px] object-contain text-4xl text-white cursor-pointer' onClick={() => setToggle((prev) => !prev)}>{toggle ? <MdClose /> : <MdOutlineKeyboardArrowDown />}</div>
          <div className={`${toggle ? 'flex' : 'hidden'} flex-col p-6 bg-white absolute xs:top-20 top-[7rem] xs:right-40 right-20 mx-4 my-2 min-w-[140px] rounded-xl sidebar`}>
            <ul className='list-none flex flex-col justify-end items-center flex-1 sm:px-12 px-8'>
                <li className={`font-openSans font-normal cursor-pointer text-[16px] text-black mb-4`}>
                  <Link href={`/market/mi-perfil`}>
                    <a>Mi Perfil</a>
                  </Link>
                </li>
                <li className={`font-openSans font-normal cursor-pointer text-[16px] text-black mb-4`}>
                  <Link href={`/market`}>
                    <a>Mercado Cripto</a>
                  </Link>
                </li>
                <li className={`font-openSans cursor-pointer text-[16px] text-red-500 font-medium`}>
                    <a onClick={logout}>Cerrar Sesión</a>
                </li>
            </ul>
          </div>
        </div>
      </div>
    </nav>
  )
}

export default Navbar