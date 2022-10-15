import React from 'react'
import Link from 'next/link'
import styles, { layout } from '../../styles/style'

const Cta = () => {
    return (
        <section id='cta' className={`flex flex-col ${styles.paddingY} bg-black-to-orange sm:mt-0 mt-10`}>
            <svg width="1920" height="220" viewBox="0 0 1920 50" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M1920 496L748.17 496L-13.2544 496L-25 -3.05176e-05C291.516 -3.05176e-05 449.277 56.0921 764.512 56.0921C1052.36 56.0921 1242.43 -3.05176e-05 1920 -3.05176e-05L1920 496Z" fill="#fe9416" />
            </svg>
            <div className={`${styles.boxWidth} m-auto`}>
                <div className='flex sm:flex-row flex-col justify-center items-center w-full'>
                    <h2 className={`${styles.heading2} ${styles.paddingX} sm:text-start text-center`}>Unite y se parte de la evolución.</h2>
                    <button typeof='button' className='sm:w-[40%] w-full sm:mt-0 mt-10'>
                        <Link href={`acceder`}>
                            <a className={`${layout.buttonWhite2}`}>
                                Empezar ahora
                            </a>
                        </Link>
                    </button>
                </div>
            </div>
        </section>
    )
}

export default Cta