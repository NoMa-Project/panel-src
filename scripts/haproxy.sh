#debian 10 / 11
#install haproxy as load balancer between 2 web servers

apt update && sudo apt -y upgrade
apt -y install haproxy

read -p "Enter ip address of web server 1: " webserver1
read -p "Enter ip address of web server 1: " webserver2


echo "frontend apache_front" >> /etc/haproxy/haproxy.cfg
# Frontend listen port - 80
echo "        bind *:80" >> /etc/haproxy/haproxy.cfg
# Set the default backend
echo "        default_backend    apache_backend_servers" >> /etc/haproxy/haproxy.cfg
# Enable send X-Forwarded-For header
echo "        option             forwardfor" >> /etc/haproxy/haproxy.cfg

echo "backend apache_backend_servers" >> /etc/haproxy/haproxy.cfg
# Use roundrobin to balance traffic
echo "        balance            roundrobin" >> /etc/haproxy/haproxy.cfg
# Define the backend servers
echo "        server             backend01 $webserver1:80 check
" >> /etc/haproxy/haproxy.cfg
echo "        server             backend02 $webserver2:80 check" >> /etc/haproxy/haproxy.cfg

systemctl restart haproxy

myip=$(ip a s dev ens33 | awk '/inet /{print $2}' | cut -d/ -f1)

echo "Haproxy is enabled. Enter $myip in your navigator to access your website."