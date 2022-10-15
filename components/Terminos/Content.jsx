import React from 'react'
import styles, { layout } from '../../styles/style'
import { terminos } from '../../constants'

const Content = () => {
    return (
        <section id='faq' className={`flex flex-col ${styles.paddingY}`}>
            <div className='flex flex-col flex-wrap justify-between'>
                {terminos.map((termino, index) => (
                    <div key={index} className='flex flex-col m-auto items-start mt-5'>
                        <p className={`${styles.heading4} font-bold text-gradient text-start max-w-[full]`}>{termino.title}</p>
                        <p className={`${styles.paragraph} text-white text-start max-w-[full] mt-5`}>{termino.text}</p>
                    </div>
                ))}
            </div>
        </section>
    )
}

export default Content