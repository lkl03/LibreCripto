import Head from 'next/head'
import Index from '../../components/Acceder/Index'
import Navbar from '../../components/Layout/Navbar'
import Footer from '../../components/Layout/Footer'
import styles from '../../styles/style'
import { logo } from '../../assets'

export default function Ayuda() {
  return (
    <div className='bg-black w-full overflow-hidden sm:[z-0]'>
        <Head>
          <title>LibreCripto | Acceder</title>
          <meta name="description" content="Generated by create next app" />
          <link rel="icon" href="/favicon.ico" />
        </Head>
        <div>
            <Index />
        </div>
    </div>
  )
}