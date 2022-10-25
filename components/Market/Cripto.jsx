import React from 'react'
import styles, { layout } from '../../styles/style'

const Cripto = ({
    name,
    price,
    symbol,
    image,
    priceChange
  }) => {
    return (
      <div className="w-full flex flex-wrap items-center justify-between py-4">
        <div className="w-full flex items-center justify-between border-b p-2">
          <div className="flex items-center gap-2">
            <img src={image} alt="crypto" className='w-[30px] h-[30px]' />
            <h2 className={`${styles.paragraph} text-center text-base text-white font-medium`}>{name}</h2>
            <p className={`${styles.paragraph} text-center text-white uppercase text-sm`}>({symbol})</p>
          </div>
          <div className="flex gap-4">
            <p className={`${styles.paragraph} text-center text-base text-white font-medium`}>${price}</p>
            {priceChange < 0 ? (
              <p className={`${styles.paragraph} text-center text-sm text-red-600 cripto-percent-red`}>{priceChange.toFixed(2)}%</p>
            ) : (
              <p className={`${styles.paragraph} text-center text-sm text-green-600 cripto-percent-red`}>{priceChange.toFixed(2)}%</p>
            )}
          </div>
        </div>
      </div>
    );
  };
  
  export default Cripto;