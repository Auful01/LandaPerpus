import { Component, OnInit } from '@angular/core';
import { NgbModal } from '@ng-bootstrap/ng-bootstrap';
import { LandaService } from 'src/app/core/services/landa.service';
import Swal from 'sweetalert2';
import { ItemService } from '../../items/services/item.service';
import { BookService } from '../service/book.service';

@Component({
    selector: 'app-daftar-buku',
    templateUrl: './daftar-buku.component.html',
    styleUrls: ['./daftar-buku.component.scss']
})
export class DaftarBukuComponent implements OnInit {

    listItems: any;
    titleCard: string;
    modelId: number;
    dtOpt: DataTables.Settings = {}
    isOpenForm: boolean = false;

    constructor(
        private bookServ: BookService,
        private landaService: LandaService,
        private modalService: NgbModal
    ) { }

    ngOnInit(): void {
        // this.getItem();
        this.dtOpt = {
            serverSide: true,
            processing: true,
            ordering: false,
            searching: false,
            pagingType: "full_numbers",
            ajax: (dataTablesParameter: any, callback) => {
                // console.log(dataTablesParameter.start);

                const page = parseInt(dataTablesParameter.start) / parseInt(dataTablesParameter.length) + 1;
                const params = {
                    nama: '',
                    page: page,
                    offset: dataTablesParameter.start,
                    limit: dataTablesParameter.length,

                };

                this.bookServ.getBooks(params).subscribe((res: any) => {
                    this.listItems = res.data.list;
                    console.log(res.data)


                    callback({
                        recordsTotal: res.data.meta.total,
                        recordsFiltered: res.data.meta.total,
                        data: []
                    });
                });
            },
        };
    }

    trackByIndex(index: number): any {
        return index;
    }

    // getItem() {
    //     this.bookServ.getBooks([]).subscribe((res: any) => {
    //         console.log(res.data);

    //         this.listItems = res.data;
    //     }, (err: any) => {
    //         console.log(err);
    //     });
    // }

    showForm(show) {
        this.isOpenForm = show;
    }

    createItem() {
        this.titleCard = 'Tambah Item';
        this.modelId = 0;
        this.showForm(true);
    }

    updateItem(itemModel) {
        this.titleCard = 'Edit Item: ' + itemModel.judul;
        this.modelId = itemModel.id;
        this.showForm(true);
    }

    deleteItem(userId) {
        Swal.fire({
            title: 'Apakah kamu yakin ?',
            text: 'Item tidak dapat melakukan pesanan setelah kamu menghapus datanya',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#34c38f',
            cancelButtonColor: '#f46a6a',
            confirmButtonText: 'Ya, Hapus data ini !',
        }).then((result) => {
            if (result.value) {
                this.bookServ.deleteBook(userId).subscribe((res: any) => {
                    this.landaService.alertSuccess('Berhasil', res.message);
                    // this.getItem();

                }, err => {
                    console.log(err);
                });
            }
        });
    }


}
