import {useState, useEffect} from 'react'
import {close, menu, logo} from '../../assets'
import {navLinks} from '../../constants'
import { layout } from '../../styles/style'
import Link from 'next/link'
import Image from 'next/image'

const Navbar = () => {
  
  const [toggle, setToggle] = useState(false)
  
  return (
    <nav className={`w-full flex py-6 justify-between items-center bg-transparent`}>
      <Link href='/'>
        <a><img src={logo.src} alt="hoobank" className='w-[180px] h-[auto]' /></a>
      </Link>
      <ul className='list-none sm:flex hidden justify-center items-center flex-1'>
        {navLinks.map((nav, index) => (
          <li key={nav.id} className={`${layout.link} font-openSans font-normal cursor-pointer text-lg ${index === navLinks.length - 1 ? 'mr-0' : 'mr-10'} text-white`}>
            <Link href={`${nav.id}`}>
              <a>{nav.title}</a>
            </Link>
          </li>
        ))}
      </ul>
      <Link href={`acceder`}>
        <a className={`${layout.buttonWhite} sm:flex hidden justify-end items-center`}>
          Ingresar
        </a>
      </Link>

      <div className='sm:hidden flex flex-1 justify-end items-center'>
        <img src={toggle ? close.src : menu.src} alt="menu" className='w-[28px] h-[28px] object-contain' onClick={() => setToggle((prev) => !prev)}/>
        
        <div className={`${toggle ? 'flex' : 'hidden'} flex-col p-6 bg-white absolute top-20 right-0 mx-4 my-2 min-w-[140px] rounded-xl sidebar`}>
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
    </nav>
  )
}

export default Navbar