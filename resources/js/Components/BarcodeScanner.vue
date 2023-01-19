<template>
    <div class="relative">
        <div v-show="!isLoading">
            <video poster="data:image/gif,AAAA" ref="scanner" class="w-full max-h-full"></video>
            <div class="overlayElement absolute top-0 h-full w-full bg-black bg-opacity-30"></div>
            <div class="laser bg-primary-900 absolute h-[1px] z-10 w-[60%] ml-[20%] top-[40%]"></div>
        </div>

        <div v-show="isLoading">
            <span class="text-center">De camera is aan het laden...</span>
        </div>

        <div v-show="!isMediaStreamAPISupported && !isLoading">
            <span class="text-center">Geef toegang tot uw camera om de barcode scanner te gebruiken</span>
        </div>
    </div>
</template>

<script>
import { BrowserMultiFormatReader, Exception } from "@zxing/library";

export default {
    name: "stream-barcode-reader",
    data() {
        return {
            isLoading: true,
            codeReader: new BrowserMultiFormatReader(),
            isMediaStreamAPISupported: navigator && navigator.mediaDevices && "enumerateDevices" in navigator.mediaDevices,
        };
    },
    mounted() {
        if (!this.isMediaStreamAPISupported) {
            throw new Exception("Media Stream API is not supported");
        }

        this.start();
        this.$refs.scanner.oncanplay = (event) => {
            this.isLoading = false;
        };
    },
    beforeUnmount() {
        this.codeReader.reset();
    },
    methods: {
        async start() {
            let selectedDeviceId = undefined
            const devices = await this.codeReader.listVideoInputDevices()

            if (devices.length > 2) {
                const selectedCamera = devices[devices.length - 1]
                selectedDeviceId = selectedCamera.deviceId
            }

            this.codeReader.decodeFromVideoDevice(selectedDeviceId, this.$refs.scanner, (result, err) => {
                if (result) {
                    this.callback(result);
                }
            });
        },
    },
    props: {
        callback: {
            required: true,
        }
    }
};
</script>

<!-- Losse styles want dit is niet mogenlijk in TailwindCSS -->
<style scoped>
.overlayElement {
    clip-path: polygon(0% 0%, 0% 100%, 20% 100%, 20% 20%, 80% 20%, 80% 80%, 20% 80%, 20% 100%, 100% 100%, 100% 0%);
    -webkit-clip-path: polygon(0% 0%, 0% 100%, 20% 100%, 20% 20%, 80% 20%, 80% 80%, 20% 80%, 20% 100%, 100% 100%, 100% 0%);
}

.laser {
    box-shadow: 0 0 4px red;
    animation: scanning 2s infinite;
    -webkit-animation: scanning 2s infinite;
}

@-webkit-keyframes scanning {
    50% {
        transform: translateY(100px);
        -webkit-transform: translateY(100px);
    }
}

@keyframes scanning {
    50% {
        transform: translateY(100px);
        -webkit-transform: translateY(100px);
    }
}
</style>