<?php

namespace App\Services\Course;

use App\Models\Course\Bahan\BahanAudio;
use App\Models\Course\Bahan\BahanConference;
use App\Models\Course\Bahan\BahanFile;
use App\Models\Course\Bahan\BahanForum;
use App\Models\Course\Bahan\BahanPelatihan;
use App\Models\Course\Bahan\BahanQuiz;
use App\Models\Course\Bahan\BahanQuizItem;
use App\Models\Course\Bahan\BahanScorm;
use App\Models\Course\Bahan\BahanTugas;
use App\Models\Course\Bahan\BahanVideo;
use App\Models\Course\MataBobotNilai;
use App\Models\Course\MataPelatihan;
use App\Models\Course\MateriPelatihan;
use App\Models\Course\Template\Bahan\TemplateBahan;
use App\Models\Course\Template\Bahan\TemplateBahanAudio;
use App\Models\Course\Template\Bahan\TemplateBahanConference;
use App\Models\Course\Template\Bahan\TemplateBahanFile;
use App\Models\Course\Template\Bahan\TemplateBahanForum;
use App\Models\Course\Template\Bahan\TemplateBahanQuiz;
use App\Models\Course\Template\Bahan\TemplateBahanQuizItem;
use App\Models\Course\Template\Bahan\TemplateBahanScorm;
use App\Models\Course\Template\Bahan\TemplateBahanTugas;
use App\Models\Course\Template\Bahan\TemplateBahanVideo;
use App\Models\Course\Template\TemplateMata;
use App\Models\Course\Template\TemplateMataBobot;
use App\Models\Course\Template\TemplateMateri;
use App\Models\Course\Template\TemplateSoal;
use App\Models\Course\Template\TemplateSoalKategori;
use App\Models\Scorm;
use App\Models\Soal\Soal;
use App\Models\Soal\SoalKategori;
use App\Services\Course\Template\TemplateMataService;

class TemplatingService
{
    private $template, $program, $mata;

    public function __construct(
        TemplateMataService $template,
        ProgramService $program,
        MataService $mata
    )
    {
        $this->template = $template;
        $this->program = $program;
        $this->mata = $mata;
    }

    public function getTemplate()
    {
        $query = TemplateMata::query();

        $query->where('publish', 1);

        $result = $query->get();

        return $result;
    }

    public function copyAsTemplate(int $mataId)
    {
        $mata = $this->mata->findMata($mataId);
        $soalKategori = $mata->soalKategori;
        $materi = $mata->materi;
        $bahan = $mata->bahan;

        if ($bahan->count() > 0) {
            //mata
            $tMata = new TemplateMata;
            $tMata->creator_id = auth()->user()->id;
            $tMata->judul = $mata->judul;
            $tMata->intro = $mata->intro ?? null;
            $tMata->content = $mata->content ?? null;
            $tMata->show_feedback = $mata->show_feedback;
            $tMata->show_comment = $mata->show_comment;
            $tMata->urutan = $mata->urutan;
            $tMata->save();

            //bobot
            $tMataBobot = new TemplateMataBobot;
            $tMataBobot->template_mata_id = $tMata->id;
            $tMataBobot->join_vidconf = $mata->bobot->join_vidconf;
            $tMataBobot->activity_completion = $mata->bobot->activity_completion;
            $tMataBobot->forum_diskusi = $mata->bobot->forum_diskusi;
            $tMataBobot->webinar = $mata->bobot->webinar;
            $tMataBobot->progress_test = $mata->bobot->enable_progress;
            $tMataBobot->quiz = $mata->bobot->quiz;
            $tMataBobot->tugas_mandiri = $mata->bobot->tugas_mandiri;
            $tMataBobot->post_test = $mata->bobot->post_test;
            $tMataBobot->save();

            //soal kategori
            if ($soalKategori->count() > 0) {
                foreach ($soalKategori as $keyKat => $valKat) {
                    $tSoalKategori = new TemplateSoalKategori;
                    $tSoalKategori->template_mata_id = $tMata->id;
                    $tSoalKategori->creator_id = auth()->user()->id;
                    $tSoalKategori->judul = $valKat->judul;
                    $tSoalKategori->keterangan = $valKat->keterangan;
                    $tSoalKategori->save();

                    //soal
                    if ($valKat->soal->count() > 0) {
                        foreach ($valKat->soal as $keySo => $valSo) {
                            $tSoal = new TemplateSoal;
                            $tSoal->template_mata_id = $tMata->id;
                            $tSoal->template_kategori_id = $tSoalKategori->id;
                            $tSoal->creator_id = auth()->user()->id;
                            $tSoal->pertanyaan = $valSo->pertanyaan;
                            $tSoal->tipe_jawaban = $valSo->tipe_jawaban;
                            $tSoal->pilihan = $valSo->pilihan;
                            $tSoal->jawaban = $valSo->jawaban;
                            $tSoal->save();
                        }
                    }
                }
            }

            //materi
            if ($materi->count() > 0) {
                foreach ($materi as $keyMat => $valMat) {
                    $tMateri = new TemplateMateri;
                    $tMateri->template_mata_id = $tMata->id;
                    $tMateri->creator_id = auth()->user()->id;
                    $tMateri->judul = $valMat->judul;
                    $tMateri->keterangan = $valMat->keterangan;
                    $tMateri->urutan = $valMat->urutan;
                    $tMateri->save();

                    if ($valMat->bahan->count() > 0) {
                        foreach ($valMat->bahan as $keyBah => $valBah) {
                            $tBahan = new TemplateBahan;
                            $tBahan->template_mata_id = $tMata->id;
                            $tBahan->template_materi_id = $tMateri->id;
                            $tBahan->creator_id = auth()->user()->id;
                            $tBahan->judul = $valBah->judul;
                            $tBahan->keterangan = $valBah->keterangan;
                            $tBahan->completion_type = $valBah->completion_type;
                            $tBahan->restrict_access = $valBah->restrict_access;
                            if ($valBah->completion_type == 3) {
                                $tBahan->completion_parameter = [
                                    'timer' => $valBah->completion_duration,
                                ];
                            } else {
                                $tBahan->completion_parameter = null;
                            }

                            if ($valBah->restrict_access == '0') {
                                $tBahan->requirement = $valBah->requirement;
                            } else {
                                $tBahan->requirement = null;
                            }
                            $tBahan->save();

                            if ($valBah->type($valBah)['tipe'] == 'forum') {
                                $segmen = new TemplateBahanForum;
                                $segmen->template_mata_id = $tMata->id;
                                $segmen->template_materi_id = $tMateri->id;
                                $segmen->template_bahan_id = $tBahan->id;
                                $segmen->creator_id = auth()->user()->id;
                                $segmen->tipe = $valBah->forum->tipe;
                                $segmen->limit_topik = $valBah->forum->limit_topik;
                                $segmen->save();
                            }

                            if ($valBah->type($valBah)['tipe'] == 'dokumen') {
                                $segmen = new TemplateBahanFile;
                                $segmen->template_mata_id = $tMata->id;
                                $segmen->template_materi_id = $tMateri->id;
                                $segmen->template_bahan_id = $tBahan->id;
                                $segmen->creator_id = auth()->user()->id;
                                $segmen->bank_data_id = $valBah->dokumen->bank_data_id;
                                $segmen->save();
                            }

                            if ($valBah->type($valBah)['tipe'] == 'conference') {
                                $segmen = new TemplateBahanConference;
                                $segmen->template_mata_id = $tMata->id;
                                $segmen->template_materi_id = $tMateri->id;
                                $segmen->template_bahan_id = $tBahan->id;
                                $segmen->creator_id = auth()->user()->id;
                                $segmen->tipe = $valBah->conference->tipe;
                                $segmen->save();
                            }

                            if ($valBah->type($valBah)['tipe'] == 'quiz') {
                                $segmen = new TemplateBahanQuiz;
                                $segmen->template_mata_id = $tMata->id;
                                $segmen->template_materi_id = $tMateri->id;
                                $segmen->template_bahan_id = $tBahan->id;
                                $segmen->creator_id = auth()->user()->id;
                                $segmen->is_mandatory = $valBah->quiz->is_mandatory;
                                $segmen->kategori = $valBah->quiz->kategori;
                                $segmen->durasi = $valBah->quiz->durasi ?? null;
                                $segmen->tipe = $valBah->quiz->tipe;
                                $segmen->view = $valBah->quiz->view;
                                $segmen->hasil = $valBah->quiz->hasil;
                                $segmen->save();

                                if ($valBah->quiz->item->count() > 0) {
                                    foreach ($valBah->quiz->item as $keyIt => $valIt) {
                                        $tBahanQuizItem = new TemplateBahanQuizItem;
                                        $tBahanQuizItem->template_mata_id = $tMata->id;
                                        $tBahanQuizItem->template_materi_id = $tMateri->id;
                                        $tBahanQuizItem->template_bahan_id = $tBahan->id;
                                        $tBahanQuizItem->template_quiz_id = $segmen->id;
                                        $tBahanQuizItem->creator_id = auth()->user()->id;
                                        $tBahanQuizItem->pertanyaan = $valIt->pertanyaan;
                                        $tBahanQuizItem->tipe_jawaban = $valIt->tipe_jawaban;
                                        if ($valIt->tipe_jawaban == 0) {
                                            $tBahanQuizItem->pilihan = $valIt->pilihan;
                                            $tBahanQuizItem->jawaban = $valIt->jawaban;

                                        } elseif ($valIt->tipe_jawaban == 1 || $valIt->tipe_jawaban == 3) {
                                            $tBahanQuizItem->jawaban = $valIt->jawaban;
                                        }
                                        $tBahanQuizItem->save();
                                    }
                                }
                            }

                            if ($valBah->type($valBah)['tipe'] == 'scorm') {
                                $segmen = new TemplateBahanScorm;
                                $segmen->template_mata_id = $tMata->id;
                                $segmen->template_materi_id = $tMateri->id;
                                $segmen->template_bahan_id = $tBahan->id;
                                $segmen->creator_id = auth()->user()->id;
                                $segmen->bank_data_id = $valBah->scorm->scorm->bank_data_id;
                                $segmen->repeatable = $valBah->scorm->repeatable;
                                $segmen->package = $valBah->scorm->scorm->package;
                                $segmen->version = $valBah->scorm->scorm->version;
                                $segmen->package_name = $valBah->scorm->scorm->package_name;
                                $segmen->save();
                            }

                            if ($valBah->type($valBah)['tipe'] == 'audio') {
                                $segmen = new TemplateBahanAudio;
                                $segmen->template_mata_id = $tMata->id;
                                $segmen->template_materi_id = $tMateri->id;
                                $segmen->template_bahan_id = $tBahan->id;
                                $segmen->creator_id = auth()->user()->id;
                                $segmen->bank_data_id = $valBah->audio->bank_data_id;
                                $segmen->save();
                            }

                            if ($valBah->type($valBah)['tipe'] == 'video') {
                                $segmen = new TemplateBahanVideo;
                                $segmen->template_mata_id = $tMata->id;
                                $segmen->template_materi_id = $tMateri->id;
                                $segmen->template_bahan_id = $tBahan->id;
                                $segmen->creator_id = auth()->user()->id;
                                $segmen->bank_data_id = $valBah->video->bank_data_id;
                                $segmen->save();
                            }

                            if ($valBah->type($valBah)['tipe'] == 'tugas') {
                                $segmen = new TemplateBahanTugas;
                                $segmen->template_mata_id = $tMata->id;
                                $segmen->template_materi_id = $tMateri->id;
                                $segmen->template_bahan_id = $tBahan->id;
                                $segmen->creator_id = auth()->user()->id;
                                $segmen->bank_data_id = $valBah->tugas->bank_data_id;
                                $segmen->approval = $valBah->tugas->approval;
                                $segmen->save();
                            }

                            $tBahan->segmenable()->associate($segmen);
                            $tBahan->save();
                        }
                    }
                }
            }

            return true;
        } else {
            return false;
        }
    }

    public function copyBankSoal(int $mataId, int $templateId)
    {
        $tMata = $this->template->findTemplateMata($templateId);
        $soalKategori = $tMata->soalKategori;

        //soal kategori
        if ($soalKategori->count() > 0) {
            foreach ($soalKategori as $keyKat => $valKat) {
                $kategori = new SoalKategori;
                $kategori->mata_id = $mataId;
                $kategori->creator_id = auth()->user()->id;
                $kategori->judul = $valKat->judul;
                $kategori->keterangan = $valKat->keterangan;
                $kategori->save();

                //soal
                if ($valKat->soal->count() > 0) {
                    foreach ($valKat->soal as $keySo => $valSo) {
                        $soal = new Soal;
                        $soal->mata_id = $mataId;
                        $soal->kategori_id = $kategori->id;
                        $soal->creator_id = auth()->user()->id;
                        $soal->pertanyaan = $valSo->pertanyaan;
                        $soal->tipe_jawaban = $valSo->tipe_jawaban;
                        $soal->pilihan = $valSo->pilihan;
                        $soal->jawaban = $valSo->jawaban;
                        $soal->save();
                    }
                }
            }
        }
        return true;

    }

    public function copyMateri($request, int $mataId, int $templateId)
    {
        $mata = $this->mata->findMata($mataId);
        $tMata = $this->template->findTemplateMata($templateId);

        $collectMateri = collect($request->materi_id);
        $collectInstruktur = collect($request->instruktur_id);
        $tMateri = TemplateMateri::whereIn('id', $collectMateri)->get();

        foreach ($tMateri as $keyMat => $valMat) {

            $materi = new MateriPelatihan;
            $materi->program_id = $mata->program_id;
            $materi->mata_id = $mataId;
            $materi->instruktur_id = $collectInstruktur[$keyMat];
            $materi->creator_id = auth()->user()->id;
            $materi->judul = $valMat->judul;
            $materi->keterangan = $valMat->keterangan;
            $materi->urutan = $valMat->urutan;
            $materi->save();

            foreach ($valMat->bahan as $keyBah => $valBah) {

                $bahan = new BahanPelatihan;
                $bahan->program_id = $mata->program_id;
                $bahan->mata_id = $mataId;
                $bahan->materi_id = $materi->id;
                $bahan->creator_id = auth()->user()->id;
                $bahan->judul = $valBah->judul;
                $bahan->keterangan = $valBah->keterangan;
                $bahan->completion_type = $valBah->completion_type;
                $bahan->completion_parameter = $valBah->completion_parameter;
                $bahan->restrict_access = $valBah->restrict_access;
                $bahan->requirement = $valBah->requirement;
                $bahan->urutan = (BahanPelatihan::where('materi_id', $materi->id)->max('urutan') + 1);
                $bahan->save();

                if ($valBah->type($valBah)['tipe'] == 'forum') {
                    $segmen = new BahanForum();
                    $segmen->program_id = $mata->program_id;
                    $segmen->mata_id = $mataId;
                    $segmen->materi_id = $materi->id;
                    $segmen->bahan_id = $bahan->id;
                    $segmen->creator_id = auth()->user()->id;
                    $segmen->tipe = $valBah->forum->tipe;
                    $segmen->limit_topik = $valBah->forum->limit_topik;
                    $segmen->save();
                }

                if ($valBah->type($valBah)['tipe'] == 'dokumen') {
                    $segmen = new BahanFile;
                    $segmen->program_id = $mata->program_id;
                    $segmen->mata_id = $mataId;
                    $segmen->materi_id = $materi->id;
                    $segmen->bahan_id = $bahan->id;
                    $segmen->creator_id = auth()->user()->id;
                    $segmen->bank_data_id = $valBah->dokumen->bank_data_id;
                    $segmen->save();
                }

                if ($valBah->type($valBah)['tipe'] == 'conference') {
                    $segmen = new BahanConference;
                    $segmen->program_id = $mata->program_id;
                    $segmen->mata_id = $mataId;
                    $segmen->materi_id = $materi->id;
                    $segmen->bahan_id = $bahan->id;
                    $segmen->creator_id = auth()->user()->id;
                    $segmen->tipe = $valBah->conference->tipe;
                    $segmen->save();
                }

                if ($valBah->type($valBah)['tipe'] == 'quiz') {
                    $segmen = new BahanQuiz;
                    $segmen->program_id = $mata->program_id;
                    $segmen->mata_id = $mataId;
                    $segmen->materi_id = $materi->id;
                    $segmen->bahan_id = $bahan->id;
                    $segmen->creator_id = auth()->user()->id;
                    $segmen->is_mandatory = $valBah->quiz->is_mandatory;
                    $segmen->kategori = $valBah->quiz->kategori;
                    $segmen->durasi = $valBah->quiz->durasi ?? null;
                    $segmen->tipe = $valBah->quiz->tipe;
                    $segmen->view = $valBah->quiz->view;
                    $segmen->hasil = $valBah->quiz->hasil;
                    $segmen->soal_acak = $valBah->quiz->soal_acak;
                    $segmen->jml_soal_acak = $valBah->quiz->jml_soal_acak;
                    $segmen->save();

                    if ($valBah->quiz->item->count() > 0) {
                        foreach ($valBah->quiz->item as $keyIt => $valIt) {
                            $BahanQuizItem = new BahanQuizItem;
                            $BahanQuizItem->program_id = $mata->program_id;
                            $BahanQuizItem->mata_id = $mataId;
                            $BahanQuizItem->materi_id = $materi->id;
                            $BahanQuizItem->bahan_id = $bahan->id;
                            $BahanQuizItem->quiz_id = $segmen->id;
                            $BahanQuizItem->creator_id = auth()->user()->id;
                            $BahanQuizItem->pertanyaan = $valIt->pertanyaan;
                            $BahanQuizItem->tipe_jawaban = $valIt->tipe_jawaban;
                            if ($valIt->tipe_jawaban == 0) {
                                $BahanQuizItem->pilihan = $valIt->pilihan;
                                $BahanQuizItem->jawaban = $valIt->jawaban;

                            } elseif ($valIt->tipe_jawaban == 1 || $valIt->tipe_jawaban == 3) {
                                $BahanQuizItem->jawaban = $valIt->jawaban;
                            }
                            $BahanQuizItem->save();
                        }
                    }
                }

                if ($valBah->type($valBah)['tipe'] == 'scorm') {

                    $scorm = new Scorm;
                    $scorm->creator_id = auth()->user()->id;
                    $scorm->bank_data_id = $valBah->scorm->bank_data_id;
                    $scorm->package = $valBah->scorm->package;
                    $scorm->version = $valBah->scorm->version;
                    $scorm->package_name = $valBah->scorm->package_name;
                    $scorm->save();

                    $segmen = new BahanScorm;
                    $segmen->program_id = $mata->program_id;
                    $segmen->mata_id = $mataId;
                    $segmen->materi_id = $materi->id;
                    $segmen->bahan_id = $bahan->id;
                    $segmen->creator_id = auth()->user()->id;
                    $segmen->scorm_id = $scorm->id;
                    $segmen->repeatable = $valBah->scorm->repeatable;
                    $segmen->save();
                }

                if ($valBah->type($valBah)['tipe'] == 'audio') {
                    $segmen = new BahanAudio;
                    $segmen->program_id = $mata->program_id;
                    $segmen->mata_id = $mataId;
                    $segmen->materi_id = $materi->id;
                    $segmen->bahan_id = $bahan->id;
                    $segmen->creator_id = auth()->user()->id;
                    $segmen->bank_data_id = $valBah->audio->bank_data_id;
                    $segmen->save();
                }

                if ($valBah->type($valBah)['tipe'] == 'video') {
                    $segmen = new BahanVideo;
                    $segmen->program_id = $mata->program_id;
                    $segmen->mata_id = $mataId;
                    $segmen->materi_id = $materi->id;
                    $segmen->bahan_id = $bahan->id;
                    $segmen->creator_id = auth()->user()->id;
                    $segmen->bank_data_id = $valBah->video->bank_data_id;
                    $segmen->save();
                }

                if ($valBah->type($valBah)['tipe'] == 'tugas') {
                    $segmen = new BahanTugas;
                    $segmen->program_id = $mata->program_id;
                    $segmen->mata_id = $mataId;
                    $segmen->materi_id = $materi->id;
                    $segmen->bahan_id = $bahan->id;
                    $segmen->creator_id = auth()->user()->id;
                    $segmen->bank_data_id = $valBah->tugas->bank_data_id;
                    $segmen->approval = $valBah->tugas->approval;
                    $segmen->save();
                }

                $bahan->segmenable()->associate($segmen);
                $bahan->save();
            }
        }
    }
}
