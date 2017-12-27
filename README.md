## complicatednetworkmeter

#### what is complicatednetworkmeter?
complicatednetworkmeter is a php cms system which makes it easier to measure the up time of each device in your network.

#### how to configure it?
in order to configure it you can choose between 'monitor' or to give up a monitor ip address inside the installation.  
if you choose for monitor it means your cms will be the main server where all the servers should ping to.  
all the non monitors are the slaves and the machines you check the status on.  

#### how to prevent use of malicious machines?
once a machine has connected to our api url it will generate a private key with the client machine, only the client could know this key.