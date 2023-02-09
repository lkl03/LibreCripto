import React from 'react'
import styles, { layout } from '../../styles/style'
import Link from 'next/link'
import { socialMedia } from '../../constants'

const Contact = () => {
    return (
        <section id='contact' className={`flex flex-col ${styles.paddingY} h-[50vh]`}>
            <p className={`${styles.heading4} flex m-auto font-medium text-center max-w-[75%]`} id="faq-librecripto">Podes ponerte en contacto con nosotros a través de cualquiera de los siguientes métodos.</p>
            <div className='flex sm:flex-row flex-col flex-wrap justify-between mt-5 z-[1]'>
                <div className='flex flex-col m-auto items-start mt-5'>
                    <p className={`${styles.heading4} font-bold text-gradient text-center max-w-[470px]`}>Email</p>
                    <p className={`${styles.paragraph} text-white text-center max-w-[470px] mt-5`}>Podes escribirnos las 24 horas del día a <Link href='mailto:contacto@librecripto.com'><a className={`${layout.link}`}>contacto@librecripto.com</a></Link></p>
                </div>
                <div className='flex flex-col m-auto items-end mt-5'>
                    <p className={`${styles.heading4} font-bold text-gradient text-center max-w-[470px]`}>Redes</p>
                    <p className={`${styles.paragraph} text-white text-center max-w-[470px] mt-5`}>Nos encontras en las siguientes redes como @Libre_Cripto</p>
                    <div className='flex flex-row m-auto mt-6'>
                    {socialMedia.map((social, index) => (
                    <Link key={social.id} href={social.link}>
                        <a target="_blank">
                            <img src={social.icon} alt={social.id} className={`w-[21px] h-[21px] object-contain cursor-pointer hover:invert-[0.25] transition-all duration-300 ease-in-out ${index !== socialMedia.length -1 ? 'mr-6' : 'mr-0'}`} />
                        </a>
                    </Link>
                    ))}
                </div>
                </div>

            </div>
        </section>
    )
}

export default Contact