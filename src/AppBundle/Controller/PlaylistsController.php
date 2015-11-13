<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Playlist;
use AppBundle\Entity\Track;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @Route("/playlists")
 */
class PlaylistsController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction()
    {
        $playlistRepository = $this->get('playlist_repository');

        return $this->render('playlists/index.html.twig', [
            'playlists' => $playlistRepository->findAll()
        ]);
    }

    /**
     * @Route("/{id}/tracks")
     * @ParamConverter("playlist", class="AppBundle:Playlist", options={"repository_method" = "withTracks"})
     * @Cache(expires="next week", public=true)
     */
    public function tracksAction(Playlist $playlist)
    {
        return $this->render('playlists/tracks.html.twig', [
            'playlist' => $playlist
        ]);
    }

    /**
     * @Route("/{id}/tracks/{trackId}")
     * @ParamConverter("track", class="AppBundle:Track", options={"id" = "trackId", "repository_method" = "withAlbumMediaTypeAndGenre"})
     */
    public function trackAction($id, Track $track)
    {
        return $this->render('playlists/track.html.twig', [
            'track' => $track
        ]);
    }

    /**
     * @ParamConverter("playlist", class="AppBundle:Playlist", options={"repository_method" = "withTracks"})
     * @Cache(public=true, maxage="3600", smaxage="7200")
     */
    public function tracksListAction(Playlist $playlist)
    {
        return $this->render('playlists/tracks-list.html.twig', [
            'playlistId' => $playlist->getId(),
            'tracks' => $playlist->getTracks()
        ]);
    }
}