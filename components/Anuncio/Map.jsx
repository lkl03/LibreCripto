import React, {useState, useMemo} from 'react'
import { GoogleMap, useJsApiLoader } from '@react-google-maps/api';
import { Audio } from  'react-loader-spinner';

const Map = ({ lat, lng }) => {
    const { isLoaded } = useJsApiLoader({
        id: 'google-map-script',
        googleMapsApiKey: 'AIzaSyC4ilNsb_eRVrPHjAsM_Qnt7cZvo7Qf1H0',
        libraries: ['places'],
    })

    const containerStyle = {
        width: '100%',
        height: '400px',
        borderRadius: 12,
    };

    const center = useMemo(() => ({ lat: lat, lng: lng }), []);

    const [map, setMap] = useState(null)

    return isLoaded ? (
        <GoogleMap
            mapContainerStyle={containerStyle}
            center={center}
            zoom={15}
            options={{
                streetViewControl: true,
                mapTypeControl: true,
                zoomControl: true,
                fullscreenControl: true,
            }}
        >
        </GoogleMap>
    ) : (
        <>
            <p>Loading Map...</p>
            <Audio
                height = "80"
                width = "80"
                radius = "9"
                color = 'green'
                ariaLabel = 'three-dots-loading'     
                wrapperStyle
                wrapperClass
            />
        </>
    )
}

export default React.memo(Map)