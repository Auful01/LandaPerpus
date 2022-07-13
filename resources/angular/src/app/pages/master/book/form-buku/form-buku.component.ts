import { Component, OnInit, SimpleChange, EventEmitter, Input, Output } from '@angular/core';
import { LandaService } from 'src/app/core/services/landa.service';
import { BookService } from '../service/book.service';

@Component({
    selector: 'app-form-buku',
    templateUrl: './form-buku.component.html',
    styleUrls: ['./form-buku.component.scss']
})
export class FormBukuComponent implements OnInit {

    @Input() itemId: number;
    @Output() afterSave = new EventEmitter<boolean>();
    mode: string;
    formModel: {
        id: number,
        id_m_kategori_buku: number,
        judul: string,
        pengarang: string,
        penerbit: string,
        tahun_terbit: string,
        isbn: string,
        keterangan: string,
        stok: number
    };
    listTipeDetail: any;

    constructor(
        private bookServ: BookService,
        private landaService: LandaService
    ) { }

    ngOnInit(): void {

    }

    ngOnChanges(changes: SimpleChange) {
        this.emptyForm();
    }

    emptyForm() {
        this.mode = 'add';
        this.formModel = {
            id: 0,
            id_m_kategori_buku: 0,
            judul: '',
            pengarang: '',
            penerbit: '',
            tahun_terbit: '',
            isbn: '',
            keterangan: '',
            stok: 0
        };

        this.listTipeDetail = [
            {
                id: 'level',
                nama: 'Level'
            },
            {
                id: 'topping',
                nama: 'Topping'
            }
        ];

        if (this.itemId > 0) {
            this.mode = 'edit';
            this.getItem(this.itemId);
        }
    }

    save() {
        if (this.mode == 'add') {
            this.bookServ.createBook(this.formModel).subscribe((res: any) => {
                this.landaService.alertSuccess('Berhasil', res.message);
                this.afterSave.emit();
            }, err => {
                this.landaService.alertError('Mohon Maaf', err.error.errors);
            });
        } else {
            this.bookServ.updateBook(this.formModel).subscribe((res: any) => {
                this.landaService.alertSuccess('Berhasil', res.message);
                this.afterSave.emit();
            }, err => {
                this.landaService.alertError('Mohon Maaf', err.error.errors);
            });
        }
    }

    getItem(itemId) {
        this.bookServ.getBookById(itemId).subscribe((res: any) => {
            console.log(res);
            this.formModel = res;
        }, err => {
            console.log(err);
        });
    }

    removeDetail(detail, paramIndex) {
        detail.splice(paramIndex, 1);
    }

    trackByIndex(index: number): any {
        return index;
    }

    back() {
        this.afterSave.emit();
    }
}
