#!/usr/local/bin/liquidsoap

### Initialize Playlists ###

# Play techoprob message every 5 minutes
techprob = single("/etc/liquidsoap/techprob.mp3")
techprob = delay(60., techprob)
techprob = mksafe(techprob)

day = playlist(reload=3600, "/media/serverplaylists/day.pls")
night = playlist(reload=3600, "/media/serverplaylists/night.pls")
spots = playlist(reload=3600, "/media/serverplaylists/stationspots.pls")

techno = playlist(reload=86400, "/media/serverplaylists/technohour.pls")
indie = playlist(reload=86400, "/media/serverplaylists/indielatenight.pls")
ska = playlist(reload=86400, "/media/serverplaylists/skatropolis.pls")
blues = playlist(reload=86400, "/media/serverplaylists/bluesafterdark.pls")

# Add more playlists here

### Possible User Request ###

# Nothin setup or worked out yet

### Playlist Selection ###

# Chooses playlist based on time of day

djauto = switch([({ 06h-20h }, day),
                ({ 20h-00h }, night),
		({ 1w and 00h-03h }, night),  #monday
                ({ 2w and 00h-03h }, night), #tuesday -- techno
                ({ 3w and 00h-03h }, night),  #wednesday -- indie
                ({ 4w and 00h-03h }, night),    #thursday -- ska
		({ 5w and 00h-03h }, night),  #friday -- blues
		({ 6w and 00h-03h }, night),  #saturday
		({ 7w and 00h-03h }, night),  #sunday
                ({ 03h-06h }, night)])

### Failure Fallback ###

# Plays "techprob" file if the playlists fail

djauto = fallback([djauto, techprob])

### Jingle Insert ###

# Randomly inserts station spots about once every 6 tracks

djauto = random(weights=[1,6],[spots, djauto])

# Possible clock jingle on the hour if wanted

### pop metadata to database w/ script ###
# Send feedback to frontend system
def extern_feedback(m)
   system( "/usr/local/git/mir-websuite/scripts/lpinsert.pl "^ quote( m["artist"] ^" "^ m["album"] ^" "^ m["title"] ) ^" &" )
end
djauto = on_metadata( extern_feedback, djauto )


### live Show Override ###

# Injects Live show instead of djauto stream during broadcasts

studioone = fallback(track_sensitive=false,
                   [input.http("http://localhost:8000/stoneshow.mp3"), djauto])

# Injects Sports Broadcast overiding all others

sports = fallback(track_sensitive=false,
                   [mksafe(input.http("http://localhost:8000/sportsshow.mp3")), djauto])

### Output Streams ###

# MP3 128k mirsports128.mp3 Sports

output.icecast.mp3(host="localhost",
                   port=8000,
		   password="mradiosrc",
		   mount="/mirsports128.mp3",
		   bitrate=128,
		   sports)

# MP3 32k mirsports32.mp3 Sports

output.icecast.mp3(host="localhost",
                   port=8000,
		   password="mradiosrc",
		   mount="/mirsports32.mp3",
		   bitrate=32,
		   samplerate=22050,
		   stereo=false,
		   sports)

# MP3 128k mirstudioone128.mp3 Studio One

output.icecast.mp3(host="localhost",
                   port=8000,
                   password="mradiosrc",
                   mount="/mirstudioone128.mp3",
		   bitrate=128,
                   studioone)

# MP3 32k mirstudioone32.mp3 Studio One

output.icecast.mp3(host="localhost",
                   port=8000,
                   password="mradiosrc",
                   mount="/mirstudioone32.mp3",
		   bitrate=32,
		   samplerate=22050,
		   stereo=false,
                   studioone)

# MP3 128k djauto.mp3 DJauto Only Stream

output.icecast.mp3(host="localhost",
                   port=8000,
                   password="mradiosrc",
                   mount="/djauto.mp3",
		   bitrate=128,
                   djauto)


