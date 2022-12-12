import React, { useState, useEffect, useContext } from "react";


import dynamic from "next/dynamic";
import { useRouter } from "next/router";

const ChatEngine = dynamic(() =>
  import("react-chat-engine").then((module) => module.ChatEngine)
);
const MessageFormSocial = dynamic(() =>
  import("react-chat-engine").then((module) => module.MessageFormSocial)
);

export default function Home() {
  const [showChat, setShowChat] = useState(false);
  const router = useRouter();

  useEffect(() => {
    if (typeof document !== undefined) {
      setShowChat(true);
    }
  }, []);

  if (!showChat) return <div />;

  return (
    <div className="background">
      <div className="shadow">
        <ChatEngine
          height="calc(100vh - 212px)"
          projectID="280851f5-d7d7-41ef-8c21-3a3974c233bd"
          userName='xx.03llkxx@gmail.com'
          userSecret='GvkXoL2pSpTqg7jE8X3wTvxcSVp1'
          renderNewMessageForm={() => <MessageFormSocial />}
        />
      </div>
    </div>
  );
}