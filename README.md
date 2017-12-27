## complicatednetworkmeter

#### what is complicatednetworkmeter?
complicatednetworkmeter is a php cms system which makes it easier to measure the up time of each device in your network.

#### how does it work?
each device needs a installation as an non monitor and connect to the main monitor.   
once a machine is connected for the first time it specifies a name etc in the url the main node will generate a private key which on next request forces the machine to know about this private key.  
when a machine fails to ping to a external website, and is also not able to ping other devices in its range it will show red that the service is down on the monitors (main node) frontpage.  

this is alot easier to setup since there is almost always a open approach to:  

lan->wan(router)->wan(firewall)->wan(isp)  

but not from wan(isp)->wan(firewall)->wan(router)->lan (a firewall should always block incomming wan unless you are a server from outside or behind a double router)  

#### how to configure it?
in order to configure it you can choose between 'monitor' or to give up a monitor ip address inside the installation.  
if you choose for monitor it means your cms will be the main server where all the servers should ping to.  
all the non monitors are the slaves and the machines you check the status on.  

#### how to prevent use of malicious machines?
once a machine has connected to our api url it will generate a private key with the client machine, only the client would know this key.