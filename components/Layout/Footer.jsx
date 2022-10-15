import React from 'react'
import styles, { layout } from '../../styles/style'
import { logofooter } from '../../assets'
import { footerLinks, socialMedia } from '../../constants'
import Link from 'next/link'

const Footer = () => (
  <section className={`${styles.flexCenter} ${styles.paddingY} flex-col sm:pt-5 pt-10`}>
    <div className={`${styles.flexStart} md:flex-row flex-col mb-8 w-full`}>
      <div className='flex-1 flex flex-col justify-start mr-10'>
        <img src={logofooter.src} alt="hoobank" className='w-[266px] h-[auto] object-contain' />
          <div className="ss:my-0 my-4 min-w-[150px]">
            <ul className='list-none mt-4 flex xl:flex-row flex-col'>
              {footerLinks.map((link, index) => (
                <li key={link.name} className={`${layout.linkBlackHover} font-montserrat font-normal text-base cursor-pointer xl:w-[200px]
                ${index == '0' ? 'xl:text-center' : ''}
                ${index == '1' ? 'xl:text-center' : ''}
                ${index == '2' ? 'xl:text-center' : ''}
                ${index == '3' ? 'xl:text-end xl:w-[240px]' : ''}
                ${index == '4' ? 'xl:text-end' : ''}`}>
                  <Link href={link.link}>
                    <a>{link.name}</a>
                  </Link>
                </li>
              ))}
            </ul>
          </div>
      </div>
    </div>
    <p className='font-montserrat font-bold text-center italic text-xs text-black mb-5'>LibreCripto© no es una entidad financiera ni ofrece servicios de ningún tipo más que la posibilidad de conectar en tiempo y forma a diferentes clientes afines a la modalidad de comercio P2P y F2F.</p>
    <div className='w-full flex justify-between items-center md:flex-row flex-col pt-6 border-t-[1px] border-white'>
      <p className='font-montserrat font-light text-center text-base leading-[27px] text-white'>LibreCripto©. Todos los derechos reservados 2022.</p>
      <div className='flex flex-row md:mt-0 mt-6'>
        {socialMedia.map((social, index) => (
          <Link href={social.link}>
            <a>
              <img key={social.id} src={social.icon} alt={social.id} className={`w-[21px] h-[21px] object-contain cursor-pointer hover:invert-[0.95] transition-all duration-300 ease-in-out ${index !== socialMedia.length - 1 ? 'mr-6' : 'mr-0'}`} />
            </a>
          </Link>))}
      </div>
    </div>
  </section>
)

export default Footer