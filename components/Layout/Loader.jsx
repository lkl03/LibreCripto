import {useState, useEffect} from 'react'
import {close, menu, logo} from '../../assets'
import {navLinks} from '../../constants'
import { layout } from '../../styles/style'
import Link from 'next/link'
import Image from 'next/image'
import { Circles } from 'react-loader-spinner'

const Loader = () => {  
  return (
    <div className='flex items-center justify-center'>
        <div className='mx-auto mt-4'><Circles height="140" width="140" color="#fe9416" ariaLabel="circles-loading" wrapperStyle={{}} wrapperClass="" visible={true} /></div>
    </div>
  )
}

export default Loader