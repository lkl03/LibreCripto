import { Fragment, useState, useContext, useEffect } from 'react'
import {close, menu, logo} from '../../assets'
import {navLinks} from '../../constants'
import styles, { layout } from '../../styles/style'
import Link from 'next/link'
import Image from 'next/image'
import { AppContext } from '../AppContext'
import { MdOutlineKeyboardArrowDown, MdClose } from 'react-icons/md'

const Navbar = () => {
  
  const [toggle, setToggle] = useState(false)

  let { user, logout } = useContext(AppContext)

  return (
    <nav className={`w-full flex xs:flex-row flex-col py-6 justify-between items-center bg-transparent`}>
      <h2 className={`${styles.heading3} xs:flex hidden`}>Mercado Cripto</h2>
      <button className='block py-2 px-4 text-sm text-gray-700' onClick={logout}>
            Cerrar sesión
      </button>
      <div className='flex gap-4 justify-center items-center'>
        <div className="rounded-full h-11 w-11 profile-icon">
          <img className='rounded-full' src={user ? user.photoURL : 'https://i.pinimg.com/originals/65/25/a0/6525a08f1df98a2e3a545fe2ace4be47.jpg'} alt="" />
        </div>
        <div className='flex flex-col'>
          <p className='text-white font-medium text-md'>{user ? user.displayName : ''}</p>
          <p className='text-[#ffffff80] italic'>{user ? `@${user.displayName.split(/\s+/).join('').toLowerCase()}` : ''}</p>
        </div>
        <div className='flex justify-end items-center'>
          <div className='w-[28px] h-[28px] object-contain text-4xl text-white cursor-pointer' onClick={() => setToggle((prev) => !prev)}>{toggle ? <MdClose /> : <MdOutlineKeyboardArrowDown />}</div>
          <div className={`${toggle ? 'flex' : 'hidden'} flex-col p-6 bg-white absolute xs:top-20 top-[7rem] xs:right-40 right-20 mx-4 my-2 min-w-[140px] rounded-xl sidebar`}>
            <ul className='list-none flex flex-col justify-end items-center flex-1'>
              {navLinks.map((nav, index) => (
                <li key={nav.id} className={`font-openSans font-normal cursor-pointer text-[16px] ${index === navLinks.length - 1 ? 'mr-0' : 'mb-4'} text-black`}>
                  <Link href={`${nav.id}`}>
                    <a>{nav.title}</a>
                  </Link>
                </li>
              ))}
            </ul>
            <Link href={`acceder`}>
              <a className={`${layout.buttonOrange} flex justify-end items-center mt-4`}>
                Ingresar
              </a>
            </Link>
          </div>
        </div>
      </div>
    </nav>
  )
}

export default Navbar